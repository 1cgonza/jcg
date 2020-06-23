<?php
$prefix = '_jcg_';

$films = new_cmb2_box(array(
	'id'            => $prefix . 'film',
	'title'         => 'Films',
	'object_types'  => array( 'films' ), // Post type
	'context'       => 'normal',
	'priority'      => 'high',
	'show_names'    => true,
));

$films->add_field(array(
	'id'      => $prefix . 'url',
	'name'    => 'URL',
	'type'    => 'oembed',
));

$films->add_field(array(
	'id'      => $prefix . 'release_date',
	'name'    => 'Release Date',
	'type'    => 'text_date_timestamp'
));

$films->add_field(array(
	'id'      => $prefix . 'synopsis',
	'name'    => 'Synopsis',
	'type'    => 'wysiwyg',
	'options' => array(
    'textarea_rows' => 5,
    'teeny' => true,
	)
));
$films->add_field(array(
	'id'      => $prefix . 'credits',
	'name'    => 'Credits',
	'type'    => 'wysiwyg',
	'options' => array(
    'textarea_rows' => 10,
    'teeny' => true,
	)
));
