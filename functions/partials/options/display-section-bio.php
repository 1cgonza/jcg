<?php
$options = (array)get_option('jcg_about_options');
$bio = !empty($options['bio']) ? $options['bio'] : '';

$settings = array(
	'media_buttons' => false,
	'textarea_name' => 'jcg_about_options[bio]'
);
wp_editor($bio, 'jcg_about_options_bio', $settings);
