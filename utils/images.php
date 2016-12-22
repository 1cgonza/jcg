<?php
add_image_size('jcg-1300x325', 1300, 325, true);
add_image_size('jcg-1200x630', 1200, 630, true);
add_image_size('jcg-900x100', 900, 100, true);
add_image_size('jcg-300', 300, 100, true);

function jcg_custom_image_sizes($sizes) {
  return array_merge($sizes, array(
    'jcg-1300x325' => '1300px by 325px',
    'jcg-1200x630' => '1200px by 630px',
    'jcg-post-nav' => '900px by 100px',
    'jcg-300x100'  => '300px by 100px'
  ));
}

function jcg_gallery( $out, $pairs, $atts ) {
  $atts = shortcode_atts( array(
    'columns' => '2',
    'size' => 'medium',
  ), $atts );

  $out['columns'] = $atts['columns'];
  $out['size']    = $atts['size'];

  return $out;
}
