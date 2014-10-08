<?php
// The custom dashicons are at: http://melchoyce.github.io/dashicons/
function custom_post_types() { 
	register_post_type( 'films',
		array(
			'labels' => array(
				'name'               => __( 'Films', 'jcgtheme' ),
				'singular_name'      => __( 'Film', 'jcgtheme' ),
				'all_items'          => __( 'All Films', 'jcgtheme' ),
				'add_new'            => __( 'Add New', 'jcgtheme' ),
				'add_new_item'       => __( 'Add New Film', 'jcgtheme' ),
				'edit'               => __( 'Edit', 'jcgtheme' ),
				'edit_item'          => __( 'Edit Film', 'jcgtheme' ),
				'new_item'           => __( 'New Film', 'jcgtheme' ),
				'view_item'          => __( 'View Film', 'jcgtheme' ),
				'search_items'       => __( 'Search Film', 'jcgtheme' ),
				'not_found'          => __( 'Nothing found in the Database.', 'jcgtheme' ),
				'not_found_in_trash' => __( 'Nothing found in Trash', 'jcgtheme' ),
				'parent_item_colon'  => ''
			),
			'description'         => __( 'The films post type with custom display.', 'jcgtheme' ),
			'public'              => true,
			'publicly_queryable'  => true,
			'exclude_from_search' => false,
			'show_ui'             => true,
			'query_var'           => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-editor-video',
			'rewrite'             => array( 'slug' => 'films', 'with_front' => false ),
			'has_archive'         => true,
			'capability_type'     => 'post',
			'hierarchical'        => false,
			'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'comments', 'revisions', 'sticky'),
			'taxonomies' 					=> array('category', 'post_tag')
	 	)
	);
	register_post_type( 'cv_meta',
		array(
			'labels' => array(
				'name'               => __( 'CV Meta', 'jcgtheme' ),
				'singular_name'      => __( 'CV Meta item', 'jcgtheme' ),
				'all_items'          => __( 'All CV Meta items', 'jcgtheme' ),
				'add_new'            => __( 'Add New', 'jcgtheme' ),
				'add_new_item'       => __( 'Add New CV Meta item', 'jcgtheme' ),
				'edit'               => __( 'Edit', 'jcgtheme' ),
				'edit_item'          => __( 'Edit CV Meta item', 'jcgtheme' ),
				'new_item'           => __( 'New CV Meta item', 'jcgtheme' ),
				'view_item'          => __( 'View CV Meta item', 'jcgtheme' ),
				'search_items'       => __( 'Search CV Meta items', 'jcgtheme' ),
				'not_found'          => __( 'Nothing found in the Database.', 'jcgtheme' ),
				'not_found_in_trash' => __( 'Nothing found in Trash', 'jcgtheme' ),
				'parent_item_colon'  => ''
			),
			'description'         => __( 'Festival Selections, Awards, Exhibitions, Conferences, Education, etc.', 'jcgtheme' ),
			'public'              => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'show_ui'             => true,
			'query_var'           => true,
			'menu_position'       => 6,
			'menu_icon'           => 'dashicons-awards',
			'has_archive'         => false,
			'capability_type'     => 'post',
			'hierarchical'        => false,
			'supports'            => array( 'title', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'revisions', 'sticky'),
			'taxonomies' 					=> array('post_tag')
	 	)
	);
} 
add_action( 'init', 'custom_post_types');

register_taxonomy( 'cv_cat',
	array('cv_meta'),
	array(
		'hierarchical' => true,
		'labels'       => array(
			'name'              => __( 'CV Categories', 'jcgtheme' ),
			'singular_name'     => __( 'CV Category', 'jcgtheme' ),
			'search_items'      => __( 'Search CV Categories', 'jcgtheme' ),
			'all_items'         => __( 'All CV Categories', 'jcgtheme' ),
			'parent_item'       => __( 'Parent CV Category', 'jcgtheme' ),
			'parent_item_colon' => __( 'Parent CV Category:', 'jcgtheme' ),
			'edit_item'         => __( 'Edit CV Category', 'jcgtheme' ),
			'update_item'       => __( 'Update CV Category', 'jcgtheme' ),
			'add_new_item'      => __( 'Add New CV Category', 'jcgtheme' ),
			'new_item_name'     => __( 'New CV Category Name', 'jcgtheme' )
		),
		'show_admin_column' => true, 
		'show_ui'           => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'cv' )
	)
);

?>