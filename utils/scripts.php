<?php
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
