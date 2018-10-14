<?php get_header();
  $postType = get_post_type();
  $archiveClass = is_post_type_archive() ? 'archive-page-' . $postType : '';
  get_template_part('parts/header', 'blog');
?>

  <div id="posts-list" class="m-all t-4of5 d-4of5 ld-4of5 <?php echo $archiveClass; ?>">
  <?php
    if ( have_posts() ) :
      while (have_posts()) : the_post();
        get_template_part( 'parts/excerpt', $postType );
      endwhile;
    else :
      get_template_part( 'parts/content', 'none' );
    endif;
  ?>
  </div>

<?php get_footer(); ?>
