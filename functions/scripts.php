<?php
function jcg_scripts_and_styles() {
  if ( !is_admin() ) {
    wp_deregister_script("jquery");
    // register main stylesheet
    wp_register_style('jcg-stylesheet', get_stylesheet_directory_uri() . '/dist/main.css', null, null, 'all');

    // Google Fonts
    wp_register_style('google-fonts', 'http://fonts.googleapis.com/css?family=Droid+Sans|Raleway:400,600');

    // comment reply script for threaded comments
    if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1) ) {
      wp_enqueue_script( 'comment-reply' );
    }

    //adding scripts file in the footer
    wp_register_script('jcg-js', get_stylesheet_directory_uri() . '/dist/main.js', null, null, true);

    // enqueue styles and scripts
    wp_enqueue_style('google-fonts');
    wp_enqueue_style('jcg-stylesheet');

    wp_enqueue_script('jcg-js');
  }
}
