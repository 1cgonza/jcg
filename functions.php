<?php
	require_once('functions/helpers.php');
	require_once('functions/support.php');
	require_once('functions/images.php');
	require_once('functions/comments.php');
	require_once('functions/cleanup.php');
	require_once('functions/contact.php');
	require_once('functions/customizer.php');
	require_once('functions/scripts.php');
	require_once('functions/admin-menu.php');

	require_once('functions/modules/cv-builder.php');

	function jcg_init() {
		add_action('init', 'disable_emojis');
		add_filter('the_generator', 'jcg_rss_version');
		add_filter('gallery_style', 'jcg_gallery_style');
		add_action('wp_enqueue_scripts', 'jcg_scripts_and_styles', 999);

		jcg_theme_support();

		add_filter('the_content', 'jcg_filter_ptags_on_images');
		add_filter('excerpt_more', 'jcg_excerpt_more');

		add_filter('image_size_names_choose', 'jcg_custom_image_sizes');
		add_filter('post_gallery', 'jcg_gallery', 10, 2);

		// Remove Open Graph from header
		add_filter('jetpack_enable_open_graph', '__return_false');

		add_filter('pre_get_posts', 'jcgj_add_custom_types_to_archives');
		add_filter('manage_edit-cv_meta_columns', 'jcgj_edit_cv_meta_columns');
		add_action('manage_cv_meta_posts_custom_column', 'jcgj_manage_cv_meta_columns', 10, 2);
		add_action('init', 'jcgj_register_post_types');
		add_filter('cmb2_admin_init', 'jcgj_metaboxes');
	}

add_action('after_setup_theme', 'jcg_init');
