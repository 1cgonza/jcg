<?php get_header(); ?>

			<div id="content" class="m-all t-4of5 d-9of10 last-col">
				<div id="main" role="main">

					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

						<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

                <header class="article-header">

                  <?php the_title( '<h1 class="entry-title cf">', '</a></h1>' ); ?>
                  <div class="article-date"><p><?php the_time('l, M d, Y') ?></p></div>

                  <div class="vcard author">By: <?php the_author(); ?></div>
                </header> <?php // end article header ?>

                <section class="entry-content cf">
                  <?php the_content(); ?>
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

                </footer> <?php // end article footer ?>

              </article> <?php // end article ?>

              <?php if( get_field('js') ): ?>
                <script type="text/javascript">
                  <?php echo get_field('js', $post->ID, false); ?>
                </script>
              <?php endif; ?>

					<?php endwhile; else : ?>

						<article id="post-not-found" class="hentry cf">
							<header class="article-header">
								<h1><?php _e( 'Oops, Post Not Found!', 'jcgtheme' ); ?></h1>
							</header>
							<section class="entry-content">
								<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'jcgtheme' ); ?></p>
							</section>
							<footer class="article-footer">
								<p><?php _e( 'This is the error message in the single.php template.', 'jcgtheme' ); ?></p>
							</footer>
						</article>
					<?php endif; ?>

             <?php
              $prevPost = get_previous_post();
              $nextPost = get_next_post();

              $postlinks = '<div class="posts-nav cf">';

              if ($prevPost) {
                $prevLink  = get_permalink($prevPost->ID);
                $prevTitle = get_the_title($prevPost->ID);
                $prevThumb = get_the_post_thumbnail($prevPost->ID, 'jcg-1300x325');

                $postlinks .= '<div class="previous-post-link">';
                  $postlinks .= '<h3 class="link-title"><a href="' . $prevLink . '" target="_self">' . $prevTitle . '</a></h3>';
                  $postlinks .= '<a href="' . $prevLink . '" target="_self">' . $prevThumb . '</a>';
                $postlinks .= '</div>';
              }

              if ($nextPost) {
                $nextLink  = get_permalink($nextPost->ID);
                $nextTitle = get_the_title($nextPost->ID);
                $nextThumb = get_the_post_thumbnail($nextPost->ID, 'jcg-1300x325');

                $postlinks .= '<div class="next-post-link">';
                  $postlinks .= '<h3 class="link-title"><a href="' . $nextLink . '" target="_self">' . $nextTitle . '</a></h3>';
                  $postlinks .= '<a href="' . $nextLink . '" target="_self">' . $nextThumb . '</a>';
                $postlinks .= '</div>';
              }

              $postlinks .= '</div>'; // end .posts-nav

              echo $postlinks;
             ?>
					<?php comments_template(); ?>
				</div>

			</div>

<?php get_footer(); ?>