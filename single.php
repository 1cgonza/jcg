<?php get_header(); ?>

    <div id="content">

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

      <article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

        <header class="article-header">
          <div class="header-meta">
            <div class="post-date">
              <p class="post-weekday"><?php the_time('l') ?></p>
              <p class="post-month-day"><?php the_time('M d') ?></p>
              <p class="post-year"><?php the_time('Y') ?></p>
            </div>

            <?php the_title( '<h1 class="h2 entry-title cf">', '</a></h1>' ); ?>
            <div class="vcard author">
              <p>By: <?php the_author(); ?></p>
            </div>
          </div>
        </header> <?php // end article header ?>

        <div class="post-categories">
          <?php
            $args = array(
            'show_option_all'    => '',
            'orderby'            => 'ID',
            'order'              => 'ASC',
            'style'              => 'list',
            'show_count'         => 0,
            'hide_empty'         => 1,
            'use_desc_for_title' => 1,
            'hierarchical'       => false,
            'title_li'           => '',
            'number'             => null,
            'echo'               => 0,
            'depth'              => 0,
            'current_category'   => 0,
            'pad_counts'         => 0,
            'exclude_tree'       => '23',
            'include'            => '',
            'taxonomy'           => 'category',
            'walker'             => null
          );
          // Load the categories call to a variable named $categoryList
          $categoryList = wp_list_categories($args);
          // Remove parenthesis around count numbers before rendering
          $categoryList = preg_replace('~\((\d+)\)(?=\s*+<)~', '$1', $categoryList);
          ?>
          <ul id="categories-menu">
            <li class="cat-item cat-item-all"><a href="<?php echo site_url(); ?>">All</a></li>
            <?php echo $categoryList; ?>
          </ul>
        </div> <?php //.post-categories ?>

        <section class="entry-content cf">
          <?php the_content(); ?>
        </section>

        <footer class="entry-footer">
          <?php
            $posttags = get_the_tags();
            if ($posttags) {
              foreach($posttags as $tag) {
                echo '<span class="entry-tag"><a href="' . get_tag_link( $tag->term_id ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $tag->name ) ) . '">'.$tag->name.'</a></span>';
              }
            }
          ?>
        </footer> <?php // end article footer ?>

      </article> <?php // end article ?>

      <?php if( get_field('js') ) : ?>
        <script type="text/javascript">
          <?php echo get_field('js', $post->ID, false); ?>
        </script>
      <?php endif;

    endwhile; else :
      get_template_part('templates/content', 'error');
    endif;

    comments_template(); ?>

    </div> <?php // #content ?>

<?php get_footer(); ?>