<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
  <header class="post-header">
    <div class="header-meta">
      <div class="post-date">
        <p class="post-weekday"><?php the_time('l') ?></p>
        <p class="post-month-day"><?php the_time('M d') ?></p>
        <p class="post-year"><?php the_time('Y') ?></p>
      </div>

      <div class="post-categories">
        <?php
          $categories = get_the_category();

          if ($categories) {
            foreach ($categories as $category) {
              echo '<span class="cat-item cat-item-' . $category->term_id . '"><a href="' . get_category_link( $category->term_id ) . '" title="' . esc_attr( sprintf("View all posts in %s", $category->name) ) . '">' . $category->cat_name . '</a></span>';
            }
          }
        ?>
      </div>
    </div>

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

  <section class="entry-excerpt-title m-all t-all d-2of5 ld-2of5">
    <?php the_title( '<h2 class="excerpt-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
  </section><!--
  --><section class="entry-excerpt m-all t-all d-3of5 ld-3of5">
    <?php the_excerpt(); ?>
  </section>

  <footer class="entry-footer">
    <?php
      $posttags = get_the_tags();
      if ($posttags) {
        foreach($posttags as $tag) {
          echo '<span class="entry-tag"><a href="' . get_tag_link( $tag->term_id ) . '" title="' . esc_attr( sprintf("View all posts in %s", $tag->name) ) . '">' . $tag->name . '</a></span>';
        }
      }
    ?>
    <p class="footer-comment-count">
      <?php comments_number( '<span>0</span> Comments', '<span>1</span> Comment', _n( '<span>%</span> Comment', '<span>%</span> Comments', get_comments_number() ) );?>
    </p>
  </footer>
</article>