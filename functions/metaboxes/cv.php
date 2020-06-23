<?php
$prefix = '_cv_';

$general = new_cmb2_box(array(
	'id'            => $prefix . 'general',
	'title'         => 'General',
	'object_types'  => array( 'cv_meta' ), // Post type
	'context'       => 'normal',
	'priority'      => 'high',
	'show_names'    => true,
));

$general->add_field(array(
	'id'      => $prefix . 'website_url',
	'name'    => 'Website URL',
	'type'    => 'text_url'
));

$general->add_field(array(
	'id'      => $prefix . 'date_current',
	'name'    => 'Website URL',
	'desc'    => 'If this item has no end date, use this checkbox to add the word "Currently" instead of the end date',
	'type'    => 'checkbox'
));

$general->add_field(array(
  'id'      => $prefix . 'date_start',
	'name'    => 'Date start',
	'type'    => 'text_date_timestamp',
));

$general->add_field(array(
	'id'      => $prefix . 'date_end',
	'name'    => 'Date end',
	'type'    => 'text_date_timestamp'
));

$general->add_field(array(
	'id'      => $prefix . 'city',
	'name'    => 'City',
	'type'    => 'text'
));

$general->add_field(array(
	'id'      => $prefix . 'country',
	'name'    => 'Country',
	'type'    => 'text'
));

$general->add_field(array(
	'id'      => $prefix . 'institution',
	'name'    => 'Institution',
	'type'    => 'text'
));

$general->add_field(array(
	'id'               => $prefix . 'award_type',
	'name'             => 'Award type',
	'type'             => 'select',
	'show_option_none' => true,
	'options'          => array(
		'honour' => 'Honour',
		'winner' => 'Winner'
	)
));

$general->add_field(array(
	'id'      => $prefix . 'award_title',
	'name'    => 'Award Title',
	'type'    => 'text'
));

$general->add_field(array(
	'id'      => $prefix . 'description',
	'name'    => 'Description',
	'type'    => 'wysiwyg',
	'options' => array(
		'textarea_rows' => 10
	)
));

$general->add_field(array(
	'id'      => $prefix . 'catalogue',
	'name'    => 'Catalogue',
	'type'    => 'file',
	'options' => array(
		'url' => false, // Hide the text input for the url
	),
));

$project = new_cmb2_box(array(
	'id'            => $prefix . 'project',
	'title'         => 'Project',
	'object_types'  => array( 'cv_meta' ), // Post type
	'context'       => 'normal',
	'priority'      => 'high',
	'show_names'    => true,
));

$project->add_field(array(
	'name'              => 'Related Project',
	'id'                => $prefix . 'related_project',
	'type'              => 'multicheck',
	'select_all_button' => false,
	'options'           => cv_get_posts_as_multicheck_options( array('films', 'experiments') )
));

$edu = new_cmb2_box(array(
	'id'            => $prefix . 'education',
	'title'         => 'Education',
	'object_types'  => array( 'cv_meta' ), // Post type
	'context'       => 'normal',
	'priority'      => 'high',
	'show_names'    => true,
));

$edu->add_field(array(
	'id'      => $prefix . 'degree',
	'name'    => 'Degree',
	'type'    => 'text',
	'attributes' => array(
		'placeholder' => 'BFA, MFA, PhD ...'
	)
));

$appointments = new_cmb2_box(array(
	'id'            => $prefix . 'appointments',
	'title'         => 'Appointments',
	'object_types'  => array( 'cv_meta' ), // Post type
	'context'       => 'normal',
	'priority'      => 'high',
	'show_names'    => true,
));

$appointments->add_field(array(
	'id'      => $prefix . 'position',
	'name'    => 'Position',
	'type'    => 'text'
));
