<?php
function jcg_query_cv_posts($postID, $terms) {
  $args = array(
    'post_type' => 'cv_meta',
    'tax_query' => array(
      array(
        'taxonomy' => 'cv_cat',
        'field'    => 'slug',
        'terms'    => $terms
      )
    ),
    'orderby'        => 'meta_value_num',
    'posts_per_page' => '-1',
    'meta_key'       => '_cv_date_start',
    'order'          => 'DESC',
    'meta_query'     => array(
      array(
        'key'     => '_cv_related_project',
        'value'   => '"' . $postID . '"',
        'compare' => 'LIKE'
      )
    )
  );
  $query = new WP_Query($args);

  return $query;
}

function jcg_get_page_metadata() {
  global $post;

  $themeOptions       = (array)get_option('jcg_theme_options');
  $defaultDescription = !empty($themeOptions['description']) ? $themeOptions['description'] : '';
  $defaultImage       = !empty($themeOptions['image']) ? $themeOptions['image'] : '';

  $returnArray = array(
    'description' => $defaultDescription,
    'ogType'      => 'website',
    'cardType'    => 'summary_large_image',
    'featuredImg' => $defaultImage,
    'url'         => jcg_get_current_url()
  );

  if ( !empty($post) ) {
    $synopsis  = get_post_meta( $post->ID, '_jcg_synopsis',                 true );
    $bgImage   = get_post_meta( $post->ID, '_jcg_header_background_image',  true );
    $gallThumb = get_post_meta( $post->ID, '_jcg_gallery_thumbnail',        true );
    /**
    * Set post types first because otherwise single is always true and can't check for post-type
    **/
    if ( is_singular('films') || !empty($synopsis) ) {
      $returnArray['description'] = wp_strip_all_tags( $synopsis, true );
      $returnArray['ogType']      = 'video.movie';
      $returnArray['cardType']    = 'player';
    } elseif ( is_singular() && !is_page() ) {
      $newExcerpt = wp_strip_all_tags($post->post_content, true);
      $newExcerpt = wp_trim_words($newExcerpt, 100, '...');

      $returnArray['description'] = $newExcerpt;
      $returnArray['ogType'] = 'article';
    }

    /*==========  FEATRED IMAGE  ==========*/
    if ( has_post_thumbnail() ) {
      $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'jcg-1200x630');
      $returnArray['featuredImg'] = $thumbnail[0];
    }
    elseif ( !empty($bgImage) ) {
      $returnArray['featuredImg'] = $bgImage;
    }
    elseif ( !empty($gallThumb) ) {
      $returnArray['featuredImg'] = $gallThumb;
    }
  }
  return $returnArray;
}

function jcg_get_current_url() {
  global $post;

  if ( is_home() || is_404() ) {
    $url = get_bloginfo('url');
  }
  elseif ( is_tax() ) {
    $url = get_term_link( get_query_var('term'), get_query_var('taxonomy') );
  }
  elseif ( is_tag() ) {
    $url = get_tag_link( get_query_var('tag_id') );
  }
  elseif ( is_post_type_archive() ) {
    $url = get_post_type_archive_link( get_query_var('post_type') );
  }
  else {
    $url = get_permalink($post->ID);
  }
  return $url;
}

/*----------  Excerpt  ----------*/
function jcg_excerpt_more($more) {
  global $post;
  return '...  <a class="excerpt-read-more" href="' . get_permalink($post->ID) . '" title="' . 'Read' . get_the_title($post->ID) . '">' . 'Read more &raquo;</a>';
}

/*----------  Page Nav  ----------*/
function jcg_page_navi() {
  global $wp_query;
  $bignum = 999999999;
  $nav = '';

  if ($wp_query->max_num_pages <= 1) {
    return;
  }

  $nav .= '<nav class="pagination">';
  $nav .= paginate_links(array(
    'base'      => str_replace( $bignum, '%#%', esc_url( get_pagenum_link($bignum) ) ),
    'format'    => '',
    'current'   => max( 1, get_query_var('paged') ),
    'total'     => $wp_query->max_num_pages,
    'prev_text' => '&larr;',
    'next_text' => '&rarr;',
    'type'      => 'list',
    'end_size'  => 3,
    'mid_size'  => 3
  ));
  $nav .= '</nav>';

  echo $nav;
}
