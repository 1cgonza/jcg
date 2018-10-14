<?php
  $thumb      = get_post_meta( $post->ID, '_jcg_excerpt_thumbnail',         true );
  $styleClass = get_post_meta( $post->ID, '_jcg_excerpt_style',             true );
  $bgCSS      = get_post_meta( $post->ID, '_jcg_excerpt_background_css',    true );
  $bgColor    = get_post_meta( $post->ID, '_jcg_excerpt_background_color',  true );
  $synopsis   = get_post_meta( $post->ID, '_jcg_synopsis',                  true );
  $embedCheck = get_post_meta( $post->ID, '_jcg_embed_video',               true );

  $styleClass = !empty($styleClass) ? 'entry-style-' . $styleClass : '';

  $inlineCSS = '';
  if ( !empty($bgCSS) ) {
    $inlineCSS =  'style="' . $bgCSS . '"';
  } elseif ( !empty($bgColor) ) {
    $inlineCSS = 'style="background-color:' . $bgColor . ';"';
  }

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('cf ' . $styleClass); ?> role="article" <?php echo $inlineCSS; ?> itemscope itemtype="http://schema.org/BlogPosting">
  <header class="article-header">
    <div class="post-image">
      <?php if ( !empty($thumb) ) : ?>
        <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><img src="<?php echo $thumb; ?>"></a>
      <?php elseif ( has_post_thumbnail() ) : ?>
        <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('jcg-1300x325'); ?></a>
      <?php else: ?>
        <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
          <img src="http://placehold.it/800x200/ECECEC/d2d2d2?text=%20" alt="<?php the_title(); ?>" />
        </a>
      <?php endif; ?>
    </div>
  </header>

  <section class="excerpt-info">
    <?php
      $link     = get_post_meta($post->ID, '_jcg_url', true);
      $date     = new DateTime( get_post_meta($post->ID, '_jcg_release_date', true) );
      $year     = date_format($date, 'Y');
      $postTags = get_the_tags();
    ?>
      <div class="excerpt-summary">
        <?php the_title( '<h2 class="excerpt-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', ' (' . $year . ')</a></h2>' ); ?>

        <?php if ( !empty($synopsis) ) : ?>
          <div class="project-synosis">
            <?php echo apply_filters( 'the_content', $synopsis ); ?>
          </div>
        <?php endif; ?>

        <?php
          if ( !empty($post->post_content) ) {
            echo '<a class="read-more" href="' . esc_url( get_permalink() ) . '" rel="bookmark">Read More...</a>';
          }
        ?>
      </div>
    <?php

      if ( !empty($link) && $embedCheck == 0 ) {
        echo '<a class="launch-btn" href="' . $link . '" target="_blank">Launch</a>';
      }

      if ($postTags) {
        echo '<div class="post-tags">';
        foreach($postTags as $tag) {
          echo '<span class="entry-tag"><a href="' . get_tag_link( $tag->term_id ) . '" title="' . esc_attr( sprintf("View all posts in %s", $tag->name) ) . '">' . $tag->name . '</a></span>';
        }
        echo '</div>';
      }
    ?>
  </section>

</article>
