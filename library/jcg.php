<?php

function jcg_head_cleanup() {
  // category feeds
  // remove_action( 'wp_head', 'feed_links_extra', 3 );
  // post and comment feeds
  // remove_action( 'wp_head', 'feed_links', 2 );
  // EditURI link
  remove_action( 'wp_head', 'rsd_link' );
  // windows live writer
  remove_action( 'wp_head', 'wlwmanifest_link' );
  // index link
  remove_action( 'wp_head', 'index_rel_link' );
  // previous link
  remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
  // start link
  remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
  // links for adjacent posts
  remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
  // WP version
  remove_action( 'wp_head', 'wp_generator' );
  // remove WP version from css
  add_filter( 'style_loader_src', 'jcg_remove_wp_ver_css_js', 9999 );
  // remove Wp version from scripts
  add_filter( 'script_loader_src', 'jcg_remove_wp_ver_css_js', 9999 );

} /* end jcg head cleanup */

// A better title
// http://www.deluxeblogtips.com/2012/03/better-title-meta-tag.html
function rw_title( $title, $sep, $seplocation ) {
  global $page, $paged;

  // Don't affect in feeds.
  if ( is_feed() ) return $title;

  // Add the blog's name
  if ( 'right' == $seplocation ) {
    $title .= get_bloginfo( 'name' );
  } else {
    $title = get_bloginfo( 'name' ) . $title;
  }

  // Add the blog description for the home/front page.
  $site_description = get_bloginfo( 'description', 'display' );

  if ( $site_description && ( is_home() || is_front_page() ) ) {
    $title .= " {$sep} {$site_description}";
  }

  // Add a page number if necessary:
  if ( $paged >= 2 || $page >= 2 ) {
    $title .= " {$sep} " . sprintf( __( 'Page %s', 'dbt' ), max( $paged, $page ) );
  }

  return $title;

} // end better title

// remove WP version from RSS
function jcg_rss_version() { return ''; }

// remove WP version from scripts
function jcg_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}

// remove injected CSS for recent comments widget
function jcg_remove_wp_widget_recent_comments_style() {
   if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
      remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
   }
}

// remove injected CSS from recent comments widget
function jcg_remove_recent_comments_style() {
  global $wp_widget_factory;
  if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
    remove_action( 'wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style') );
  }
}

// remove injected CSS from gallery
function jcg_gallery_style($css) {
  return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );
}
/*------------------------------------

          SCRIPTS & ENQUEUEING

--------------------------------------*/

// loading modernizr and jquery, and reply script
function jcg_scripts_and_styles() {
  global $wp_styles; // call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way

  if (!is_admin()) {
    // modernizr (without media query polyfill)
    // wp_register_script( 'jcg-modernizr', get_stylesheet_directory_uri() . '/library/js/libs/modernizr.custom.min.js', array(), '2.5.3', false );

    // register main stylesheet
    wp_register_style( 'jcg-stylesheet', get_stylesheet_directory_uri() . '/library/css/style.css', array(), '', 'all' );

    // ie-only style sheet
    // wp_register_style( 'jcg-ie-only', get_stylesheet_directory_uri() . '/library/css/ie.css', array(), '' );

    // comment reply script for threaded comments
    if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
      wp_enqueue_script( 'comment-reply' );
    }

    //adding scripts file in the footer
    wp_register_script( 'jcg-js', get_stylesheet_directory_uri() . '/library/js/scripts.js', array( 'jquery' ), '', true );

    // enqueue styles and scripts
    // wp_enqueue_script( 'jcg-modernizr' );
    wp_enqueue_style( 'jcg-stylesheet' );
    // wp_enqueue_style( 'jcg-ie-only' );

    $wp_styles->add_data( 'jcg-ie-only', 'conditional', 'lt IE 9' ); // add conditional wrapper around ie stylesheet

    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'jcg-js' );

  }
}
/*------------------------------------

              THEME SUPPORT

--------------------------------------*/

// Adding WP 3+ Functions & Theme Support
function jcg_theme_support() {
  // wp thumbnails (sizes handled in functions.php)
  add_theme_support( 'post-thumbnails' );

  // default thumb size
  set_post_thumbnail_size(125, 125, true);

  // rss thingy
  add_theme_support('automatic-feed-links');

  // wp menus
  add_theme_support( 'menus' );

  // registering wp3+ menus
  register_nav_menus(
    array(
      'main-nav' => 'The Main Menu',   // main nav in header
    )
  );

  // JETPACK INFINITE SCROLL
  add_theme_support( 'infinite-scroll', array(
    'type'           => 'scroll',
    'footer_widgets' => false,
    'container'      => 'posts-list',
    'wrapper'        => true,
    'render'         => false,
    'posts_per_page' => false
  ) );

  /*------------------------------------

               CUSTOM COLUMNS

  --------------------------------------*/

  add_filter( 'manage_edit-cv_meta_columns', 'jcg_edit_cv_meta_columns' ) ;
  // CV META
  function jcg_edit_cv_meta_columns( $columns ) {
    $columns = array(
        'cb'            => '<input type="checkbox" />',
        'title'         => __( 'CV Item' ),
        'country'       => __( 'Country' ),
        'film'          => __( 'Film' ),
        'cv_categories' => __( 'CV Categories' ),
        'date'          => __( 'Date' )
    );
    return $columns;
  }

  add_action( 'manage_cv_meta_posts_custom_column', 'jcg_manage_cv_meta_columns', 10, 2 );

  function jcg_manage_cv_meta_columns( $column, $post_id ) {
    global $post;

    switch( $column ) {
      case 'country' :
        $country = get_post_meta( $post_id, 'country', true );

        if ( empty( $country ) ) {
          echo __( 'Unknown' );
        } else {
          echo __( $country );
        }

        break;

      case 'film' :
        $films = get_field('related_films');

        if( $films ) {
          foreach( $films as $film ) {
            echo '<a href="' . get_permalink( $film->ID ) . '">' . get_the_title( $film->ID ) . '</a><br />';
          }
        }

        break;

      case 'cv_categories' :
        $terms = get_the_terms( $post_id, 'cv_cat' );

        if ( !empty( $terms ) ) {
          $out = array();

          foreach ( $terms as $term ) {
            $out[] = sprintf( '<a href="%s">%s</a>',
              esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'cv_cat' => $term->slug ), 'edit.php' ) ),
              esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'cv_categories', 'display' ) )
            );
          }
          /* Join the terms, separating them with a comma. */
          echo join( ', ', $out );
        } else {
          _e( 'No CV Categories' );
        }

        break;
        /* Just break out of the switch statement for everything else. */
      default :
        break;
    }
  }
} /* end jcg theme support */

/*------------------------------------

          RANDOM CLEANUP ITEMS

--------------------------------------*/

// remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function jcg_filter_ptags_on_images($content){
  return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

// This removes the annoying […] to a Read More link
function jcg_excerpt_more($more) {
  global $post;
  // edit here if you like
  return '...  <a class="excerpt-read-more" href="'. get_permalink($post->ID) . '" title="'. 'Read' . get_the_title($post->ID).'">'. 'Read more &raquo;' .'</a>';
}

//disable WordPress sanitization to allow more than just $allowedtags from /wp-includes/kses.php
remove_filter('pre_user_description', 'wp_filter_kses');
//add sanitization for WordPress posts
add_filter( 'pre_user_description', 'wp_filter_post_kses');

?>