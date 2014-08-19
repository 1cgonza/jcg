              <article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

                <header class="article-header">
                  <div class="header-meta">
                    <div class="post-date">
                      <p class="post-weekday"><?php the_time('l') ?></p>
                      <p class="post-month-day"><?php the_time('M d') ?></p>
                      <p class="post-year"><?php the_time('Y') ?></p>
                    </div>

                    <div class="post-categories">
                      <?php
                        $categories = get_the_category();

                        if($categories){
                          foreach($categories as $category) {
                            echo '<p class="cat-item cat-item-' . $category->term_id . '"><a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">'.$category->cat_name.'</a></p>';
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
                        <img src="<?php bloginfo('template_directory'); ?>/library/images/no-image.png" alt="<?php the_title(); ?>" />
                      </a>
                    <?php } ?>
                  </div>

                </header> <?php // end article header ?>

                <?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

                <section class="entry-excerpt cf">
                  <?php the_excerpt(); ?>
                </section> <?php // end article section ?>

                <footer class="entry-footer">

                  <?php
                    $posttags = get_the_tags();
                    if ($posttags) {
                      foreach($posttags as $tag) {
                        echo '<span class="entry-tag"><a href="'.get_tag_link( $tag->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $tag->name ) ) . '">'.$tag->name.'</a></span>';
                      }
                    }
                  ?>

                  <p class="footer-comment-count">
                    <?php comments_number( __( '<span>0</span> Comments', 'jcgtheme' ), __( '<span>1</span> Comment', 'jcgtheme' ), _n( '<span>%</span> Comments', '<span>%</span> Comments', get_comments_number(), 'jcgtheme' ) );?>
                  </p>

                </footer> <?php // end article footer ?>

              </article> <?php // end article ?>