<?php get_header(); ?>
    <div id="content">
      <?php
      if ( is_post_type_archive() ) : get_template_part( 'templates/header', get_post_type($post->ID) );
      else : get_template_part( 'templates/header', 'defaults' );
      endif;
      ?>

      <?php
      if ( have_posts() ) : get_template_part( 'templates/wrapper', 'wide' );
      while ( have_posts() ) : the_post();
        get_template_part( 'templates/content', get_post_format() );
      endwhile;
        echo '</div>'; // close wrapper
      else : get_template_part('templates/content', 'error');
      endif;
      ?>
    </div> <?php // #content ?>

<?php get_footer(); ?>