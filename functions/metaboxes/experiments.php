<?php
$prefix = '_jcg_';

$experiments = new_cmb2_box(array(
	'id'            => $prefix . 'experiment',
	'title'         => 'Experiment',
	'object_types'  => array( 'experiments' ), // Post type
	'context'       => 'normal',
	'priority'      => 'high',
	'show_names'    => true,
));

$experiments->add_field(array(
	'id'      => $prefix . 'url',
	'name'    => 'URL',
	'type'    => 'text_url',
));

$experiments->add_field(array(
	'id'      => $prefix . 'release_date',
	'name'    => 'Release Date',
	'type'    => 'text_date_timestamp'
));

$experiments->add_field(array(
	'id'      => $prefix . 'synopsis',
	'name'    => 'Synopsis',
	'type'    => 'wysiwyg',
	'options' => array(
    'textarea_rows' => 5,
    'teeny' => true,
	)
));

$experiments->add_field(array(
	'id'      => $prefix . 'credits',
	'name'    => 'Credits',
	'type'    => 'wysiwyg',
	'options' => array(
    'textarea_rows' => 10,
    'teeny' => true,
	)
));

$experiments->add_field( array(
  'id'        => $prefix . 'header_style',
	'name'      => 'Header Style',
	'desc'      => 'Change text color depending on background',
	'type'      => 'select',
	'default'   => 'light',
	'options'   => array(
		'dark'  => 'Dark',
		'light' => 'Light'
	),
));

$experiments->add_field(array(
	'id'      => $prefix . 'header_background_overlay',
	'name'    => 'Header background overlay',
	'type'    => 'colorpicker'
));


$experiments->add_field(array(
	'id'      => $prefix . 'header_background_image',
	'name'    => 'Header background image',
	'type'    => 'file',
	'options' => array(
    'url' => true,
	)
));

$experiments->add_field(array(
	'id'      => $prefix . 'embed_video',
  'name'    => 'Has video',
  'desc'    => 'Check to display video in the header instead of image/description.',
	'type'    => 'checkbox',
));
