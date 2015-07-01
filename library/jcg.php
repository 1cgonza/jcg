<?php

function jcg_head_cleanup() {
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
}

// remove WP version from RSS
function jcg_rss_version() {
  return '';
}

// remove WP version from scripts
function jcg_remove_wp_ver_css_js( $src ) {
  if ( strpos( $src, 'ver=' ) ){
    $src = remove_query_arg( 'ver', $src );
  }
  return $src;
}

// remove injected CSS for recent comments widget
function jcg_remove_wp_widget_recent_comments_style() {
  if ( has_filter('wp_head', 'wp_widget_recent_comments_style') ) {
    remove_filter('wp_head', 'wp_widget_recent_comments_style');
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


/*============================================
=            SCRIPTS & ENQUEUEING            =
============================================*/
function jcg_scripts_and_styles() {
  if ( !is_admin() ) {
    // modernizr (without media query polyfill)
    wp_register_script('jcg-modernizr', get_stylesheet_directory_uri() . '/library/js/libs/modernizr.custom.min.js', array(), '2.5.3', false);

    // register main stylesheet
    wp_register_style('jcg-stylesheet', get_stylesheet_directory_uri() . '/library/css/style.css', array(), '', 'all');

    // Google Fonts
    wp_register_style('google-fonts', 'http://fonts.googleapis.com/css?family=Droid+Sans|Raleway:400,600');

    // comment reply script for threaded comments
    if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1) ) {
      wp_enqueue_script( 'comment-reply' );
    }

    //adding scripts file in the footer
    wp_register_script('jcg-js', get_stylesheet_directory_uri() . '/library/js/scripts.js', array( 'jquery' ), '', true);

    // enqueue styles and scripts
    wp_enqueue_script('jcg-modernizr');
    wp_enqueue_style('google-fonts');
    wp_enqueue_style('jcg-stylesheet');

    wp_enqueue_script('jquery');
    wp_enqueue_script('jcg-js');
  }
}
/*-----  End of SCRIPTS & ENQUEUEING  ------*/

/*=====================================
=            THEME SUPPORT            =
=====================================*/
function jcg_theme_support() {
  add_editor_style();
  add_theme_support('post-thumbnails');
  set_post_thumbnail_size(125, 125, true);
  add_theme_support('automatic-feed-links');
  add_theme_support('menus');
  jcg_register_navigation();
  add_theme_support('title-tag');

  /*==========  POST EDITOR FORMATS  ==========*/
  add_filter('mce_buttons_2', 'jcg_mce_buttons_2');
  add_filter('tiny_mce_before_init', 'jcg_mce_before_init_insert_formats');

  /*==========  CUSTOM COLUMNS  ==========*/
  add_filter('manage_edit-cv_meta_columns', 'jcg_edit_cv_meta_columns');
  add_action('manage_cv_meta_posts_custom_column', 'jcg_manage_cv_meta_columns', 10, 2);
}

/*==========  CALLBACKS  ==========*/
function jcg_register_navigation() {
  register_nav_menus(
    array(
      'main-nav' => 'The Main Menu'
    )
  );
}

function jcg_mce_buttons_2($buttons) {
  array_unshift($buttons, 'styleselect');
  return $buttons;
}

function jcg_mce_before_init_insert_formats($init_array) {
  // Define the style_formats array
  $style_formats = array(
    // Each array child is a format with it's own settings
    array(
      'title'   => 'JCG Gallery',
      'block'   => 'div',
      'classes' => 'jcg-gallery',
      'wrapper' => true
    ),
    array(
      'title'   => 'Full Width',
      'block'   => 'div',
      'classes' => 'jcg-fullwidth',
      'wrapper' => true
    ),
    array(
      'title'   => 'Inline Image',
      'inline'  => 'span',
      'classes' => 'jcg-inline-img',
      'wrapper' => true
    )
  );
  // Insert the array, JSON ENCODED, into 'style_formats'
  $init_array['style_formats'] = json_encode($style_formats);
  return $init_array;
}

function jcg_edit_cv_meta_columns($columns) {
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

function jcg_manage_cv_meta_columns($column, $post_id) {
  global $post;

  if ($column == 'country') {
    $country = get_post_meta($post_id, 'country', true);
    echo empty($country) ? 'Unknown' : $country;
  }
  elseif ($column == 'film') {
    $films       = get_post_meta($post_id, 'related_films', true);
    $filmsReturn = '';

    if ($films) {
      foreach ($films as $film) {
        $filmsReturn .= '<a href="' . get_permalink($film) . '">' . get_the_title($film) . '</a><br />';
      }
      echo $filmsReturn;
    }
  }
  elseif ($column == 'cv_categories') {
    $terms = get_the_terms($post_id, 'cv_cat');
    if ( empty($terms) ) {
      echo 'No CV Categories';
    } else {
      $termsReturn = '';
      foreach ($terms as $term) {
        $url = esc_url( add_query_arg( array('post_type' => $post->post_type, 'cv_cat' => $term->slug), 'edit.php' ) );
        // var_dump($url);
        $termsReturn .= '<a href="' . $url . '">' . $term->name . '</a><br />';
      }
      echo $termsReturn;
    }
  }
}
/*-----  End of THEME SUPPORT  ------*/

function jcg_query_cv_posts($postID, $terms) {
  $args = array(
    'post_type' => 'cv_meta',
    'tax_query' => array(
      array(
        'taxonomy' => 'cv_cat',
        'field'    => 'slug',
        'terms'    => $terms
      )
    ),
    'orderby'        => 'meta_value_num',
    'posts_per_page' => '-1',
    'meta_key'       => 'date_start',
    'order'          => 'DESC',
    'meta_query'     => array(
      array(
        'key'     => 'related_films',
        'value'   => '"' . $postID . '"',
        'compare' => 'LIKE'
      )
    )
  );
  $query = new WP_Query($args);

  return $query;
}

/*=======================================
=            PAGE NAVIGATION            =
=======================================*/
function jcg_page_navi() {
  global $wp_query;
  $bignum = 999999999;
  $nav = '';

  if ($wp_query->max_num_pages <= 1) {
    return;
  }

  $nav .= '<nav class="pagination">';
  $nav .= paginate_links(array(
    'base'      => str_replace( $bignum, '%#%', esc_url( get_pagenum_link($bignum) ) ),
    'format'    => '',
    'current'   => max( 1, get_query_var('paged') ),
    'total'     => $wp_query->max_num_pages,
    'prev_text' => '&larr;',
    'next_text' => '&rarr;',
    'type'      => 'list',
    'end_size'  => 3,
    'mid_size'  => 3
  ));
  $nav .= '</nav>';

  echo $nav;
}
/*-----  End of PAGE NAVIGATION  ------*/

function jcg_get_current_url() {
  global $post;

  if ( is_home() || is_404() ) {
    $url = get_bloginfo('url');
  }
  elseif ( is_tax() ) {
    $url = get_term_link( get_query_var('term'), get_query_var('taxonomy') );
  }
  elseif ( is_tag() ) {
    $url = get_tag_link( get_query_var('tag_id') );
  }
  elseif ( is_post_type_archive() ) {
    $url = get_post_type_archive_link( get_query_var('post_type') );
  }
  else {
    $url = get_permalink($post->ID);
  }
  return $url;
}

function jcg_get_page_metadata() {
  global $post;

  $themeOptions       = (array)get_option('jcg_theme_options');
  $defaultDescription = !empty($themeOptions['description']) ? $themeOptions['description'] : '';
  $defaultImage       = !empty($themeOptions['image']) ? $themeOptions['image'] : '';

  $returnArray = array(
    'description' => $defaultDescription,
    'ogType'      => 'website',
    'cardType'    => 'summary_large_image',
    'featuredImg' => $defaultImage,
    'url'         => jcg_get_current_url()
  );

  if ( !empty($post) ) {
    $metaData = get_post_custom($post->ID);
    /**
    * Set post types first because otherwise single is always true and can't check for post-type
    **/
    if ( is_singular('films') && !empty($metaData['synopsis']) ) {
      $returnArray['description'] = $metaData['synopsis'][0];
      $returnArray['ogType']      = 'video.movie';
      $returnArray['cardType']    = 'player';
    } elseif ( is_singular() && !is_page() ) {
      $newExcerpt = wp_strip_all_tags($post->post_content, true);
      $newExcerpt = wp_trim_words($newExcerpt, 100, '...');

      $returnArray['description'] = $newExcerpt;
      $returnArray['ogType'] = 'article';
    }

    /*==========  FEATRED IMAGE  ==========*/
    if ( has_post_thumbnail() ) {
      $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'jcg-1200x630');
      $returnArray['featuredImg'] = $thumbnail[0];
    }
    elseif ( !empty($metaData['background_image'][0]) ) {
      $returnArray['featuredImg'] = $metaData['background_image'][0];
    }
    elseif ( !empty($metaData['gallery_thumbnail'][0]) ) {
      $returnArray['featuredImg'] = $metaData['gallery_thumbnail'][0];
    }
  }
  return $returnArray;
}

function jcg_contact_info() {
  $externalLinks = [];
  $aboutData     = (array)get_option('jcg_about_options');
  $primaryEmail  = !empty( $aboutData['email'] ) ? antispambot($aboutData['email']) : NULL;
  $phone         = !empty( $aboutData['phone'] ) ? $aboutData['phone'] : NULL;
  /*==========  SOCIAL LINKS  ==========*/
  $github   = !empty( $aboutData['github'] )    ? $externalLinks['GitHub']   = $aboutData['github']   : NULL;
  $vimeo    = !empty( $aboutData['vimeo'] )     ? $externalLinks['Vimeo']    = $aboutData['vimeo']    : NULL;
  $youtube  = !empty( $aboutData['youtube'] )   ? $externalLinks['YouTube']  = $aboutData['youtube']  : NULL;
  $facebook = !empty( $aboutData['facebook'] )  ? $externalLinks['Facebook'] = $aboutData['facebook'] : NULL;
  $twitter  = !empty( $aboutData['twitter'] )   ? $externalLinks['Twitter']  = $aboutData['twitter']  : NULL;
  $flickr   = !empty( $aboutData['flickr'] )    ? $externalLinks['Flickr']   = $aboutData['flickr']   : NULL;
  $linkedin = !empty( $aboutData['linkedin'] )  ? $externalLinks['LinkedIn'] = $aboutData['linkedin'] : NULL;
  $imdb     = !empty( $aboutData['imdb'] )      ? $externalLinks['IMDB']     = $aboutData['imdb']     : NULL;

  $contact = '<div class="jcg-contact-info">';
    $contact .= $primaryEmail ? '<span class="contact-item primary-email">' . $primaryEmail . '</span>' : '';
    $contact .= $phone ? '<span class="contact-item phone-number">' . $phone . '</span>' : '';
      $contact .= '<ul id="social-links">';
      foreach ($externalLinks as $vendor => $url) {
        $contact .= '<li><a class="' . strtolower($vendor) . ' social-icon" href="' . $url . '" target="_blank">' . $vendor . '</a></li>';
      }
    $contact .= '</ul>';
  $contact .= '</div>';

  return $contact;
}

/*===============================================
=            OTHER CLEANUP FUNCTIONS            =
===============================================*/
/**
* Remove the <p> from around imgs
* http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/
**/
function jcg_filter_ptags_on_images($content){
  $content = preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
  $content = preg_replace('/<p>\s*(<span .*>*.<\/span>)\s*<\/p>/iU', '\1', $content);
  return preg_replace('/<p>\s*(<iframe .*>*.<\/iframe>)\s*<\/p>/iU', '\1', $content);
}

/**
* Change the link at the end of excerpts
**/
function jcg_excerpt_more($more) {
  global $post;
  return '...  <a class="excerpt-read-more" href="' . get_permalink($post->ID) . '" title="' . 'Read' . get_the_title($post->ID) . '">' . 'Read more &raquo;</a>';
}

function disable_emojis() {
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('admin_print_scripts', 'print_emoji_detection_script');
  remove_action('wp_print_styles', 'print_emoji_styles');
  remove_action('admin_print_styles', 'print_emoji_styles');
  remove_filter('the_content_feed', 'wp_staticize_emoji');
  remove_filter('comment_text_rss', 'wp_staticize_emoji');
  remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
  add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
}

function disable_emojis_tinymce($plugins) {
  if ( is_array($plugins) ) {
    return array_diff( $plugins, array('wpemoji') );
  } else {
    return array();
  }
}
/*-----  End of OTHER CLEANUP FUNCTIONS  ------*/