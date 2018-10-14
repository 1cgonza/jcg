<?php
  get_header();
  $postJS = '';

    if ( have_posts() ) :
      while ( have_posts() ) : the_post();
        get_template_part( 'parts/content', get_post_type() );

        $jsField = get_post_field('js', $post->ID, 'raw');
        if ( !empty($jsField) ) {
          $postJS = $jsField;
        }
      endwhile;
    else :
      get_template_part('parts/content', 'none');
    endif;

    if ( !empty($postJS) ) {
      echo '<script type="text/javascript">' . $postJS . '</script>';
    }
  get_footer();