<?php
function jcgj_register_theme_options_pages() {
	require_once dirname(__FILE__) . '/partials/jcgj-register-theme-options.php';
}
add_action('admin_menu', 'jcgj_register_theme_options_pages');

function jcgj_init_theme_options()	{
	require_once dirname(__FILE__) . '/partials/jcg-init-theme-options.php';
}
add_action('admin_init', 'jcgj_init_theme_options');
