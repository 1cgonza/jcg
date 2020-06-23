<?php
function jcg_theme_support() {
	add_theme_support('post-thumbnails');
	add_theme_support('automatic-feed-links');
	add_theme_support('menus');
	add_theme_support('title-tag');
	add_theme_support('html5', array(
    'comment-form',
    'comment-list',
    'search-form',
    'gallery',
    'caption'
	));

	add_editor_style();

	set_post_thumbnail_size(125, 125, true);

	register_nav_menus(
		array(
			'main-nav' => 'The Main Menu'
		)
	);

	/*==========  POST EDITOR FORMATS  ==========*/
	add_filter('mce_buttons_2', 'jcg_mce_buttons_2');
	add_filter('tiny_mce_before_init', 'jcg_mce_before_init_insert_formats');
}

/*==========  CALLBACKS  ==========*/
function jcg_mce_buttons_2($buttons) {
	array_unshift($buttons, 'styleselect');
	return $buttons;
}

function jcg_mce_before_init_insert_formats($init_array) {
  // Define the style_formats array
	$style_formats = array(
		// Each array child is a format with it's own settings
		array(
			'title'   => 'JCG Gallery',
			'block'   => 'div',
			'classes' => 'jcg-gallery',
			'wrapper' => true
		),
		array(
			'title'   => 'Full Width',
			'block'   => 'div',
			'classes' => 'jcg-fullwidth',
			'wrapper' => true
		),
		array(
			'title'   => 'Inline Image',
			'inline'  => 'span',
			'classes' => 'jcg-inline-img',
			'wrapper' => true
		)
	);
	// Insert the array, JSON ENCODED, into 'style_formats'
	$init_array['style_formats'] = json_encode($style_formats);
	return $init_array;
}

function jcgj_add_custom_types_to_archives($query) {
	if (is_category() || is_tag() && empty($query->query_vars['suppress_filters'])) {
		$query->set('post_type', array(
			'post', 'nav_menu_item', 'films', 'experiments'
		));
		return $query;
	}
}

function jcgj_edit_cv_meta_columns($columns) {
	$columns = array(
		'cb'            => '<input type="checkbox" />',
		'title'         => 'CV Item',
		'country'       => 'Country',
		'project'       => 'Project',
		'cv_categories' => 'CV Categories',
		'date'          => 'Date'
	);
	return $columns;
}

function jcgj_manage_cv_meta_columns($column, $post_id) {
	global $post;

	if ($column == 'country') {
		$country = get_post_meta($post_id, '_cv_country', true);
		echo empty($country) ? 'Unknown' : $country;
	} elseif ($column == 'project') {
		$films       = get_post_meta($post_id, '_cv_related_project', true);
		$ret = '';

		if (!empty($films)) {
			foreach ($films as $film) {
				$ret .= '<a href="' . get_permalink($film) . '">' . get_the_title($film) . '</a><br />';
			}
		}
		echo $ret;
	} elseif ($column == 'cv_categories') {
		$terms = get_the_terms($post_id, 'cv_cat');

		if (empty($terms)) {
			echo 'No CV Categories';
		} else {
			$termsReturn = '';
			foreach ($terms as $term) {
				$url = esc_url(add_query_arg(array('post_type' => $post->post_type, 'cv_cat' => $term->slug), 'edit.php'));
				$termsReturn .= '<a href="' . $url . '">' . $term->name . '</a><br />';
			}
			echo $termsReturn;
		}
	}
}

function jcgj_metaboxes() {
	if (!function_exists('new_cmb2_box')) {
		return;
	}
  require_once dirname(__FILE__) . '/metaboxes/cv.php';
  require_once dirname(__FILE__) . '/metaboxes/films.php';
  require_once dirname(__FILE__) . '/metaboxes/experiments.php';
}

function jcgj_register_post_types() {
	require_once dirname(__FILE__) . '/partials/jcgj-post-types.php';
}

class JCG_Settings {
	public function __construct($id, $title, $cb, $page, $name) {
		$this->ID = $id;
		$this->name = $name;
		$this->page = $page;

		add_settings_section($id, $title, $cb, $page);
		$this->register();
	}

	public function register() {
		register_setting($this->ID, $this->name);
	}

	public function addField($id, $title, $cb) {
		add_settings_field( $id, $title, $cb, $this->page, $this->ID);
	}
}

function jcg_get_social() {
	return array(
		'github'   => 'GitHub',
		'vimeo'    => 'Vimeo',
		'youtube'  => 'YouTube',
		'facebook' => 'Facebook',
		'twitter'  => 'Twitter',
		'flickr'   => 'Flickr',
		'linkedin' => 'LinkedIn',
		'imdb'     => 'IMDB'
	);
}

function cv_get_posts_as_multicheck_options($types) {
	global $post;
	$posts = array();

	$query = new WP_Query(array(
		'post_type'      => $types,
		'order'          => 'DESC',
		'orderby'        => 'date',
		'posts_per_page' => -1
	));

	while ($query->have_posts()) :
		$query->the_post();
		$posts[$post->ID] = '[' . $post->post_type . '] ' . $post->post_title;
	endwhile;

	return $posts;
}
