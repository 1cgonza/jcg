<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
  <header class="article-header">
    <div class="post-image">
      <?php if ( has_post_thumbnail() ) { ?>
        <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('jcg-1300x325'); ?></a>
      <?php } else { ?>
        <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
          <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/library/images/no-image.png" alt="<?php the_title(); ?>" />
        </a>
      <?php } ?>
    </div>
  </header>

  <section class="entry-excerpt-title">
    <?php
    $date = new DateTime( get_post_meta($post->ID, 'release_date', true) );
    $year = date_format($date, 'Y');
    the_title( '<h2 class="excerpt-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', ' (' . $year . ')</a></h2>' );
    ?>
  </section>

  <section class="entry-excerpt cf">
    <?php the_field('synopsis'); ?>
  </section> <?php // end article section ?>

  <footer class="entry-footer">
    <?php
      $posttags = get_the_tags();
      if ($posttags) {
        foreach($posttags as $tag) {
          echo '<span class="entry-tag"><a href="' . get_tag_link( $tag->term_id ) . '" title="' . esc_attr( sprintf("View all posts in %s", $tag->name) ) . '">' . $tag->name . '</a></span>';
        }
      }
    ?>
  </footer>
</article>