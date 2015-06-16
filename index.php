<?php get_header(); ?>

  <?php get_template_part('header', 'blog'); ?>

  <div id="posts-list" class="m-all t-4of5 d-4of5 ld-4of5">
  <?php
    if ( have_posts() ) :
      while (have_posts()) : the_post();
        get_template_part( 'excerpt', get_post_format() );
      endwhile;
    else :
      get_template_part( 'content', 'none' );
    endif;
  ?>
  <?php jcg_page_navi(); ?>
  </div>

<?php get_footer(); ?>