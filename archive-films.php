<?php
global $jcgDescription;
$jcgDescription = 'test';
get_header();
?>

    <div id="content" class="">
  		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
        <header class="film-post-header">
          <?php
          /*------------------------------------------
                              TITLE
          --------------------------------------------*/
          ?>
          <?php the_title( '<h1 class="h2 entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' ); ?>
        </header>

        <section class="film-post-excerpt cf">
         	<?php //the_field('synopsis'); ?>
        </section> <?php // end article section ?>

        <footer class="film-post-footer">
          <?php
          $postTags = get_the_tags();
          if ($postTags) {
            foreach($postTags as $tag) {
              echo '<span class="entry-tag"><a href="' . get_tag_link($tag->term_id) . '" title="' . esc_attr( sprintf( __("View all posts in %s"), $tag->name ) ) . '">' . $tag->name . '</a></span>';
            }
          }
          ?>
        </footer> <?php // end article footer ?>
        <?php
        /*------------------------------------------
                              IMAGE
        --------------------------------------------*/
        ?>
        <div class="film-post-image">
          <?php if ( has_post_thumbnail() ) : ?>
            <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('jcg-1300x325'); ?></a>
          <?php else : ?>
            <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
              <img src="<?php bloginfo('template_directory'); ?>/library/images/no-image.png" alt="<?php the_title(); ?>" />
            </a>
          <?php endif; ?>
        </div>
      </article> <?php // end article ?>

      <?php endwhile; endif; ?>

    </div> <?php // end #content ?>

<?php get_footer(); ?>