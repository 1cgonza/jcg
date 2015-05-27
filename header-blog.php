<header id="description-box">
  <?php
    $archiveTitle = '';
    $catDescription = '';

    if ( is_category() ) {
      $catDescription = category_description();

      if (empty( $catDescription) ) {
        $archiveTitle = single_cat_title('', false);
      }
    }
    elseif ( is_tax() ) {
      $archiveTitle = single_term_title('', false);
    }
    elseif ( is_tag() ) {
      $archiveTitle = single_tag_title('', false);
    }
    elseif ( is_author() ) {
      global $post;
      $archiveTitle = get_the_author();
    }
    elseif ( is_day() ) {
      $archiveTitle = get_the_time('l, F j, Y');
    }
    elseif ( is_month() ) {
      $archiveTitle = get_the_time('F Y');
    }
    elseif ( is_year() ) {
      $archiveTitle = get_the_time('Y');
    }
    elseif ( is_search() ) {
      $archiveTitle = 'Search results for: ' . esc_attr( get_search_query() );
    }
    else {
      $archiveTitle = 'Blog';
    }

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
    'include'            => '',
    'taxonomy'           => 'category',
    'walker'             => null
  );
  // Load the categories call to a variable named $categoryList
  $categoryList = wp_list_categories( $args );
  // Remove parenthesis around count numbers before rendering
  $categoryList = preg_replace('~\((\d+)\)(?=\s*+<)~', '$1', $categoryList);
  // Render categories

  if ( !empty($archiveTitle) ) {
    echo '<h1 class="description-title">' . $archiveTitle . '</h1>';
  }

  if ( !empty($catDescription) ) {
    echo '<div class="blog-header-description">' . $catDescription . '</div>';
  }
  echo '<ul id="categories-menu">';
    echo '<li class="cat-item cat-item-all current-cat"><a href="' . site_url() . '">All</a></li>' . $categoryList;
  echo '</ul>';
  ?>

  <div class="search-box">
    <?php get_search_form(); ?>
  </div>
</header>
<?php jcg_page_navi(); ?>