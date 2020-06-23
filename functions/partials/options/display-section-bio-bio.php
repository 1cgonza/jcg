<?php
$options = (array)get_option('jcg_about_options');
$bio = !empty($options['bio_bio']) ? $options['bio_bio'] : '';

$settings = array(
	'media_buttons' => false,
	'textarea_name' => 'jcg_about_options[bio_bio]'
);
wp_editor($bio, 'jcg_about_options_bio_bio', $settings);
