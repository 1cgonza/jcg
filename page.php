<?php
  get_header();

    if ( have_posts() ) :
      while ( have_posts() ) : the_post();
        get_template_part('parts/content', 'page');
      endwhile;
    else :
      get_template_part('parts/content', 'none');
    endif;

  get_footer();
