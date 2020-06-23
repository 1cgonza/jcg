<?php

function jcgj_customize_register($wp_customize) {
	$wp_customize->add_setting('site_logo', array(
		'transport' => 'refresh',
	));

	$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'site_logo', array(
		'label'     => 'Site logo/name',
		'section'   => 'title_tagline',
		'settings'  => 'site_logo'
	)));
}
add_action('customize_register', 'jcgj_customize_register');

function jcgj_login_url() {
    return home_url();
}
add_filter('login_headerurl', 'jcgj_login_url');

function jcgj_login_title() {
    return get_option('blogname');
}
add_filter('login_headertext', 'jcgj_login_title');
