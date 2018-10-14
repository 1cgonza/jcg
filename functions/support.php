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
