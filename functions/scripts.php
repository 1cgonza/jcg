<?php
function jcg_scripts_and_styles() {
	if ( !is_admin() ) {
		wp_deregister_script('jquery');
		// register main stylesheet
		wp_register_style('jcg-stylesheet', get_stylesheet_directory_uri() . '/dist/jcgj.css', null, null, 'all');

		// Google Fonts
		wp_register_style('google-fonts', 'https://fonts.googleapis.com/css?family=Droid+Sans|Raleway:400,600');

		// comment reply script for threaded comments
		if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		//adding scripts file in the footer
		wp_register_script('jcg-js', get_stylesheet_directory_uri() . '/dist/jcgj.js', null, null, true);

		// enqueue styles and scripts
		wp_enqueue_style('google-fonts');
		wp_enqueue_style('jcg-stylesheet');

		wp_enqueue_script('jcg-js');
	}
}

function jcgj_enqueue_scripts($page) {
	$dist = get_stylesheet_directory_uri() . '/dist/';
	wp_enqueue_script('jcgj-admin-js', $dist . 'jcgj-admin.js', array( 'jquery' ), null, 'all' );
	wp_enqueue_style('jcgj-admin-css', $dist . 'jcgj-admin.css', array(), null, 'all');

    if ( $page == 'toplevel_page_jcg_options' ) {
		wp_enqueue_media();
		wp_enqueue_script( 'jcgj' . '-upload', $dist . 'jcgj-upload.js', array( 'jquery' ), null, 'all' );
    }
}
add_action('admin_enqueue_scripts', 'jcgj_enqueue_scripts');

function jcgj_enqueue_login_styles() {
    wp_enqueue_style('jcgj', get_stylesheet_directory_uri() . '/dist/jcgj-login.css', array(), null, 'all' );
}
add_action('login_enqueue_scripts', 'jcgj_enqueue_login_styles');

