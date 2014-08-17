<?php
/*
 Template Name: Contact
*/
global $post;
get_header(); ?>

			<div id="content" class="m-all t-4of5 d-9of10 last-col">
				<div id="contact-wrapper">

					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

						<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?>>
							<header class="article-header">
								<h1><?php the_title(); ?></h1>
							</header>

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
									<p><?php _e( 'This is the error message in the page-custom.php template.', 'jcgtheme' ); ?></p>
							</footer>
						</article>

					<?php endif; ?>

				</div> <?php // end #contact-wrapper ?>

			</div> <?php // end #content ?>

<?php get_footer(); ?>