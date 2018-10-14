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

function jcg_gallery($output, $attr) {
  global $post;

  if (isset($attr['orderby'])) {
    $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
    if (!$attr['orderby']) {
      unset($attr['orderby']);
    }
  }

  extract(shortcode_atts(array(
    'order' => 'ASC',
    'orderby' => 'menu_order ID',
    'id' => $post->ID,
    'itemtag' => 'dl',
    'icontag' => 'dt',
    'captiontag' => 'dd',
    'columns' => 3,
    'size' => 'thumbnail',
    'include' => '',
    'exclude' => ''
  ), $attr));

  $id = intval($id);

  if ('RAND' == $order) $orderby = 'none';

  if (!empty($include)) {
    $include = preg_replace('/[^0-9,]+/', '', $include);
    $_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
    $attachments = array();

    foreach ($_attachments as $key => $val) {
      $attachments[$val->ID] = $_attachments[$key];
    }
  }

  if (empty($attachments)) {
    return '';
  }

  // Here's your actual output, you may customize it to your needs
  $output = '<div class="jcg-gallery">';
  $output .= '<div class="preloader"></div>';
  $output .= '<div class="thumbnails">';

  foreach ($attachments as $id => $attachment) {
    $thumb = wp_get_attachment_image_src($id, 'thumbnail');
    $img = wp_get_attachment_image_src($id, 'large');
    $output .= '<img src="' . $thumb[0] . '" alt="" data-large="' . $img[0] . '" />';
  }
  $output .= '</div>';
  $output .= '<div class="jcg-gallery-image-container"></div>';
  $output .= '</div>';

  return $output;
}
