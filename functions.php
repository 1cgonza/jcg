<?php
  require_once('utils/helpers.php');
  require_once('utils/support.php');
  require_once('utils/images.php');
  require_once('utils/sidebars.php');
  require_once('utils/comments.php');
  require_once('utils/cleanup.php');
  require_once('utils/contact.php');
  require_once('utils/customizer.php');
  require_once('utils/scripts.php');

  function jcg_init() {
    add_action('init', 'disable_emojis');
    add_filter('the_generator', 'jcg_rss_version');
    // add_filter('wp_head', 'jcg_remove_wp_widget_recent_comments_style', 1);
    // add_action('wp_head', 'jcg_remove_recent_comments_style', 1);
    add_filter('gallery_style', 'jcg_gallery_style');
    add_action('wp_enqueue_scripts', 'jcg_scripts_and_styles', 999);

    jcg_theme_support();

    add_action('widgets_init', 'jcg_register_sidebars');
    add_filter('the_content', 'jcg_filter_ptags_on_images');
    add_filter('excerpt_more', 'jcg_excerpt_more');

    add_filter('image_size_names_choose', 'jcg_custom_image_sizes');
    add_filter('shortcode_atts_gallery', 'jcg_gallery', 10, 3 );

    // Remove Open Graph from header
    add_filter('jetpack_enable_open_graph', '__return_false');
  }
  add_action('after_setup_theme', 'jcg_init');
