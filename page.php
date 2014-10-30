<?php get_header(); ?>

			<div id="content" class="m-all t-4of5 d-9of10 last-col">


					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

						<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
              <header class="article-header">
                <?php the_title( '<h1 class="h2 entry-title cf">', '</a></h1>' ); ?>
              </header> <?php // end article header ?>

              <section class="entry-content cf">
                <?php the_content(); ?>
              </section>
            </article> <?php // end article ?>

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

			</div>

<?php get_footer(); ?>