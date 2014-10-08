<?php
	/*===================================*\
	 *                                   *
	 *  DASHBOARD WIDGETS CUSTOMIZATION  *
	 *                                   *
	\*===================================*/

	function disable_default_dashboard_widgets() {
		// remove_meta_box( 'dashboard_right_now', 'dashboard', 'core' );    // Right Now Widget
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'core' ); // Comments Widget
		remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'core' );  // Incoming Links Widget
		remove_meta_box( 'dashboard_plugins', 'dashboard', 'core' );         // Plugins Widget
		// remove_meta_box('dashboard_quick_press', 'dashboard', 'core' );  // Quick Press Widget
		remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'core' );   // Recent Drafts Widget
		remove_meta_box( 'dashboard_primary', 'dashboard', 'core' );         //
		remove_meta_box( 'dashboard_secondary', 'dashboard', 'core' );       //
		// removing plugin dashboard boxes
		remove_meta_box( 'yoast_db_widget', 'dashboard', 'normal' );         // Yoast's SEO Plugin Widget
	}
	add_action( 'admin_menu', 'disable_default_dashboard_widgets' );

	/*===================================*\
	 *                                   *
	 *         CUSTOM LOGIN PAGE         *
	 *                                   *
	\*===================================*/

	function jcg_login_css() {
		wp_enqueue_style( 'jcg_login_css', get_template_directory_uri() . '/library/css/login.css', false );
	}
	function jcg_login_url() {  return home_url(); }
	function jcg_login_title() { return get_option( 'blogname' ); }

	add_action( 'login_enqueue_scripts', 'jcg_login_css', 10 );
	add_filter( 'login_headerurl', 'jcg_login_url' );
	add_filter( 'login_headertitle', 'jcg_login_title' );


	/************* CUSTOMIZE ADMIN *******************/
	function jcg_custom_admin_footer() {
		_e( '<span id="footer-thankyou">Developed by <a href="http://www.juancgonzalez.com" target="_blank">Juan Camilo Gonz&aacute;lez</a></span>.', 'jcgtheme' );
	}
	add_filter( 'admin_footer_text', 'jcg_custom_admin_footer' );

?>