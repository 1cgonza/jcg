<div id="description-box">
  <?php if ( is_category() ) { ?>
  <h1 class="archive-title"><?php single_cat_title(); ?></h1>
  <div class="blog-header-description"><?php echo category_description(); ?></div>

  <?php } elseif ( is_tag() ) { ?>
  <h1 class="archive-title"><?php single_tag_title(); ?></h1>
  <div class="blog-header-description"><?php echo tag_description(); ?></div>

  <?php } elseif ( is_author() ) {
  global $post; $author_id = $post->post_author; ?>
  <h1 class="archive-title"><?php the_author_meta('display_name', $author_id); ?></h1>

  <?php } elseif ( is_day() ) { ?>
  <h1 class="archive-title"><?php the_time('l, F j, Y'); ?></h1>

  <?php } elseif ( is_month() ) { ?>
  <h1 class="archive-title"><?php the_time('F Y'); ?></h1>

  <?php } elseif ( is_year() ) { ?>
  <h1 class="archive-title"><?php the_time('Y'); ?></h1>
  <?php } ?>

  <?php
  $args = array(
    'show_option_all'    => '',
    'orderby'            => 'ID',
    'order'              => 'ASC',
    'style'              => 'list',
    'show_count'         => 0,
    'hide_empty'         => 1,
    'use_desc_for_title' => 1,
    'hierarchical'       => false,
    'title_li'           => '',
    'number'             => null,
    'echo'               => 0,
    'depth'              => 0,
    'current_category'   => 0,
    'pad_counts'         => 0,
    'exclude_tree'       => '23',
    'include'            => '',
    'taxonomy'           => 'category',
    'walker'             => null
  );
  $categoryList = wp_list_categories($args); ?>

  <ul id="categories-menu">
    <li class="cat-item cat-item-all"><a href="<?php echo site_url(); ?>">All</a></li>
    <?php echo $categoryList; ?>
  </ul>

  <div class="search-box">
    <?php get_search_form(); ?>
  </div>

</div> <?php // #description-box ?>