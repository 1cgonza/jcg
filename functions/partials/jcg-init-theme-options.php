<?php
$general = new JCG_Settings(
	'general_section',  // Section ID
	'',                 // Section Title
	'',                 // Section Callback
	'jcg_options',      // Page where to display section
	'jcg_theme_options' // Setting name: how it gets saved on the DB
);

$general->addField(
	'default_image',
	'Default Image',
	'jcg_render_default_image'
);

$general->addField(
	'jcg_options_description',
	'Default description',
	'jcg_render_option_description'
);

/*==========  ABOUT  ==========*/
$about = new JCG_Settings(
	'about_section',    // Section ID
	'',                 // Section Title
	'',                 // Section Callback
	'jcg_about',        // Page where to display section
	'jcg_about_options' // Setting name: how it gets saved on the DB
);

$about->addField(
	'jcg_about_contact',
	'Contact',
	'jcg_render_contact'
);

$about->addField(
	'jcg_about_social',
	'Social Links',
	'jcg_render_social'
);

$about->addField(
	'jcg_about_bio',
	'Bio Academic',
	'jcg_render_bio'
);

$about->addField(
	'jcg_about_bio_bio',
	'Bio Biographical',
	'jcg_render_bio_bio'
);

/*==========  CALLBACK FUNCTIONS  ==========*/
function jcg_render_option_description() {
	require_once dirname( __FILE__ ) . '/options/display-section-description.php';
}

function jcg_render_default_image() {
	require_once dirname( __FILE__ ) . '/options/display-section-default-image.php';
}

function jcg_render_contact() {
	require_once dirname( __FILE__ ) . '/options/display-section-contact.php';
}

function jcg_render_social() {
	require_once dirname( __FILE__ ) . '/options/display-section-social.php';
}

function jcg_render_bio() {
	require_once dirname( __FILE__ ) . '/options/display-section-bio.php';
}

function jcg_render_bio_bio() {
	require_once dirname( __FILE__ ) . '/options/display-section-bio-bio.php';
}
