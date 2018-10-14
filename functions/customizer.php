<?php

function jcgj_customize_register($wp_customize) {
  $wp_customize->add_setting( 'site_logo' , array(
    'transport' => 'refresh',
  ));

  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'site_logo', array(
    'label'     => 'Site logo/name',
    'section'   => 'title_tagline',
    'settings'  => 'site_logo'
  )));
}
add_action('customize_register', 'jcgj_customize_register');
