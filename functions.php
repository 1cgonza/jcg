<?php
  require_once('functions/helpers.php');
  require_once('functions/support.php');
  require_once('functions/images.php');
  require_once('functions/comments.php');
  require_once('functions/cleanup.php');
  require_once('functions/contact.php');
  require_once('functions/customizer.php');
  require_once('functions/scripts.php');

  function jcg_init() {
    add_action('init', 'disable_emojis');
    add_filter('the_generator', 'jcg_rss_version');
    add_filter('gallery_style', 'jcg_gallery_style');
    add_action('wp_enqueue_scripts', 'jcg_scripts_and_styles', 999);

    jcg_theme_support();

    add_filter('the_content', 'jcg_filter_ptags_on_images');
    add_filter('excerpt_more', 'jcg_excerpt_more');

    add_filter('image_size_names_choose', 'jcg_custom_image_sizes');
    add_filter('post_gallery', 'jcg_gallery', 10, 2);

    // Remove Open Graph from header
    add_filter('jetpack_enable_open_graph', '__return_false');
  }
  
  add_action('after_setup_theme', 'jcg_init');
