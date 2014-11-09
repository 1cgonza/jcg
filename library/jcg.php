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


/*********************
SCRIPTS & ENQUEUEING
*********************/

// loading modernizr and jquery, and reply script
function jcg_scripts_and_styles() {
  global $wp_styles; // call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way

  if (!is_admin()) {

    // modernizr (without media query polyfill)
    wp_register_script( 'jcg-modernizr', get_stylesheet_directory_uri() . '/library/js/libs/modernizr.custom.min.js', array(), '2.5.3', false );

    // register main stylesheet
    wp_register_style( 'jcg-stylesheet', get_stylesheet_directory_uri() . '/library/css/style.css', array(), '', 'all' );

    // comment reply script for threaded comments
    if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
		  wp_enqueue_script( 'comment-reply' );
    }

    //adding scripts file in the footer
    wp_register_script( 'jcg-js', get_stylesheet_directory_uri() . '/library/js/scripts.js', array( 'jquery' ), '', true );

    // enqueue styles and scripts
    wp_enqueue_script( 'jcg-modernizr' );
    wp_enqueue_style( 'jcg-stylesheet' );

    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'jcg-js' );

  }
}

/*********************
THEME SUPPORT
*********************/

// Adding WP 3+ Functions & Theme Support
function jcg_theme_support() {
  // this hooks the editor-styles.css
  add_editor_style();

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
			'main-nav' => __( 'The Main Menu', 'jcgtheme' ),   // main nav in header
		)
	);
  /*===========================================
  =            FORMATS POST EDITOR            =
  ===========================================*/
  // Callback function to insert 'styleselect' into the $buttons array
  function oss_mce_buttons_2( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
  }
  // Register our callback to the appropriate filter
  add_filter('mce_buttons_2', 'oss_mce_buttons_2');

  function jcg_mce_before_init_insert_formats( $init_array ) {
    // Define the style_formats array
    $style_formats = array(
      // Each array child is a format with it's own settings
      array(
        'title' => 'JCG Gallery',
        'block' => 'div',
        'classes' => 'jcg-gallery',
        'wrapper' => true,
      ),
      array(
        'title' => 'Full Width',
        'block' => 'div',
        'classes' => 'jcg-fullwidth',
        'wrapper' => true,
      ),
      array(
        'title' => 'Inline Image',
        'inline' => 'span',
        'classes' => 'jcg-inline-img',
        'wrapper' => true,
      )
    );
    // Insert the array, JSON ENCODED, into 'style_formats'
    $init_array['style_formats'] = json_encode( $style_formats );
    return $init_array;
  }
  // Attach callback to 'tiny_mce_before_init'
  add_filter( 'tiny_mce_before_init', 'jcg_mce_before_init_insert_formats' );

  /*-----  End of FORMATS POST EDITOR  ------*/

  // JETPACK INFINITE SCROLL
  add_theme_support( 'infinite-scroll', array(
    'type'           => 'scroll',
    'footer_widgets' => false,
    'container'      => 'posts-list',
    'wrapper'        => true,
    'render'         => false,
    'posts_per_page' => false
  ) );



  /*********************
      CUSTOM COLUMNS
  *********************/
  add_filter( 'manage_edit-cv_meta_columns', 'jcg_edit_cv_meta_columns' ) ;
  // CV META
  function jcg_edit_cv_meta_columns( $columns ) {
    $columns = array(
        'cb'            => '<input type="checkbox" />',
        'title'         => 'CV Item',
        'country'       => 'Country',
        'film'          => 'Film',
        'cv_categories' => 'CV Categories',
        'date'          => 'Date'
    );
    return $columns;
  }

  add_action( 'manage_cv_meta_posts_custom_column', 'jcg_manage_cv_meta_columns', 10, 2 );

  function jcg_manage_cv_meta_columns( $column, $post_id ) {
    global $post;
    switch( $column ) {
      /* If displaying the 'duration' column. */
      case 'country' :
        /* Get the post meta. */
        $country = get_post_meta( $post_id, 'country', true );
        /* If no duration is found, output a default message. */
        if ( empty( $country ) )
          echo 'Unknown';
        /* If there is a duration, append 'minutes' to the text string. */
        else
          echo $country;
        break;

      /* If displaying the 'duration' column. */
      case 'film' :
        $films = get_field('related_films');

        if( $films ): ?>
          <?php foreach( $films as $film ): ?>
            <a href="<?php echo get_permalink( $film->ID ); ?>"><?php echo get_the_title( $film->ID ); ?></a><br />
          <?php endforeach; ?>
        <?php endif;
        break;

        case 'cv_categories' :
        /* Get the genres for the post. */
        $terms = get_the_terms( $post_id, 'cv_cat' );
        /* If terms were found. */
        if ( !empty( $terms ) ) {
          $out = array();
          /* Loop through each term, linking to the 'edit posts' page for the specific term. */
          foreach ( $terms as $term ) {
            $out[] = sprintf( '<a href="%s">%s</a>',
              esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'cv_cat' => $term->slug ), 'edit.php' ) ),
              esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'cv_categories', 'display' ) )
            );
          }
          /* Join the terms, separating them with a comma. */
          echo join( ', ', $out );
        }
        /* If no terms were found, output a default message. */
        else {
          echo 'No CV Categories';
        }
        break;
      /* Just break out of the switch statement for everything else. */
      default :
        break;
    }
  }
} /* end jcg theme support */

/*********************
RELATED POSTS FUNCTION
*********************/

// Related Posts Function (call using jcg_related_posts(); )
function jcg_related_posts() {
	echo '<ul id="jcg-related-posts">';
	global $post;
	$tags = wp_get_post_tags( $post->ID );
	if($tags) {
		foreach( $tags as $tag ) {
			$tag_arr .= $tag->slug . ',';
		}
        $args = array(
        	'tag' => $tag_arr,
        	'numberposts' => 5, /* you can change this to show more */
        	'post__not_in' => array($post->ID)
     	);
        $related_posts = get_posts( $args );
        if($related_posts) {
        	foreach ( $related_posts as $post ) : setup_postdata( $post ); ?>
	           	<li class="related_post"><a class="entry-unrelated" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
	        <?php endforeach; }
	    else { ?>
            <?php echo '<li class="no_related_post">' . __( 'No Related Posts Yet!', 'jcgtheme' ) . '</li>'; ?>
		<?php }
	}
	wp_reset_query();
	echo '</ul>';
} /* end jcg related posts function */

/*********************
PAGE NAVI
*********************/

// Numeric Page Navi (built into the theme by default)
function jcg_page_navi() {
  global $wp_query;
  $bignum = 999999999;
  if ( $wp_query->max_num_pages <= 1 )
    return;

  echo '<nav class="pagination">';
  echo paginate_links( array(
    'base'         => str_replace( $bignum, '%#%', esc_url( get_pagenum_link($bignum) ) ),
    'format'       => '',
    'current'      => max( 1, get_query_var('paged') ),
    'total'        => $wp_query->max_num_pages,
    'prev_text'    => '&larr;',
    'next_text'    => '&rarr;',
    'type'         => 'list',
    'end_size'     => 3,
    'mid_size'     => 3
  ) );
  echo '</nav>';
} /* end page navi */

/*********************
RANDOM CLEANUP ITEMS
*********************/

// remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function jcg_filter_ptags_on_images($content){
  $content = preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
  $content = preg_replace('/<p>\s*(<span .*>*.<\/span>)\s*<\/p>/iU', '\1', $content);
  return preg_replace('/<p>\s*(<iframe .*>*.<\/iframe>)\s*<\/p>/iU', '\1', $content);
}

// This removes the annoying […] to a Read More link
function jcg_excerpt_more($more) {
	global $post;
	// edit here if you like
return '...  <a class="excerpt-read-more" href="'. get_permalink($post->ID) . '" title="'. __( 'Read', 'jcgtheme' ) . get_the_title($post->ID).'">'. __( 'Read more &raquo;', 'jcgtheme' ) .'</a>';
}



?>
