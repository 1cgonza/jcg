<?php get_header(); ?>

    <div id="content">
      <?php
      if ( have_posts() ) : get_template_part( 'templates/wrapper', 'narrow' );
      while ( have_posts() ) : the_post();
        get_template_part( 'templates/content', 'page' );
      endwhile;
        echo '</div>'; // close wrapper
      else : get_template_part('templates/content', 'error');
      endif;
      ?>
    </div> <?php // #content ?>

<?php get_footer(); ?>