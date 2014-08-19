<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
  <header class="article-header">
    <?php the_title( '<h1 class="entry-title cf">', '</a></h1>' ); ?>
  </header> <?php // end article header ?>

  <section class="entry-content cf">
    <?php the_content(); ?>
  </section>
</article> <?php // end article ?>