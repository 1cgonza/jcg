<?php get_header();
  $postType = get_post_type();
  if ($postType == 'post') {
    get_template_part('header', 'blog');
  }
?>

  <div id="posts-list" class="m-all t-4of5 d-4of5">
  <?php
    if ( have_posts() ) :
      while (have_posts()) : the_post();
        get_template_part( 'excerpt', $postType );
      endwhile;
    else :
      get_template_part( 'content', 'none' );
    endif;
  ?>
  </div>

<?php get_footer(); ?>
