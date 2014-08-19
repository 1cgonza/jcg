<?php get_header(); ?>

    <div id="content">
      <?php get_template_part( 'templates/header', get_post_format() ); ?>

      <?php
      if ( have_posts() ) : get_template_part( 'templates/wrapper', 'wide' );
      while ( have_posts() ) : the_post();
        get_template_part( 'templates/content', get_post_format() );
      endwhile;
        echo '</div>'; // close wrapper
      else : get_template_part('templates/content', 'error');
      endif;
      ?>
    </div> <?php // end #content ?>

<?php get_footer(); ?>
