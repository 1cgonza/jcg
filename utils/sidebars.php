<?php
function jcg_register_sidebars() {
  register_sidebar(array(
    'id'            => 'sidebar1',
    'name'          => 'Sidebar 1',
    'description'   => 'The first (primary) sidebar.',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h4 class="widgettitle">',
    'after_title'   => '</h4>',
  ));
}