<?php get_header(); ?>

			<div id="content" class="m-all t-4of5 d-9of10 last-col">

				<div id="description-box">
					<?php if (is_category()) { ?>
						<?php echo '<div class="blog-header-description">' . category_description() . '</div>'; ?>

					<?php } elseif (is_tag()) { ?>
						<h1 class="archive-title">
							<?php single_tag_title(); ?>
						</h1>

					<?php } elseif (is_author()) { global $post; $author_id = $post->post_author; ?>
						<h1 class="archive-title">
							<?php the_author_meta('display_name', $author_id); ?>
						</h1>

					<?php } elseif (is_day()) { ?>
						<h1 class="archive-title">
							<?php the_time('l, F j, Y'); ?>
						</h1>

					<?php } elseif (is_month()) { ?>
						<h1 class="archive-title">
							<?php the_time('F Y'); ?>
						</h1>

					<?php } elseif (is_year()) { ?>
						<h1 class="archive-title">
							<?php the_time('Y'); ?>
						</h1>
					<?php } ?>

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
						'exclude_tree'			 => '23',
						'include'						 => '',
						'taxonomy'           => 'category',
						'walker'             => null
					);
					// Load the categories call to a variable named $categoryList
					$categoryList = wp_list_categories( $args );
					// Remove parenthesis around count numbers before rendering
					$categoryList = preg_replace('~\((\d+)\)(?=\s*+<)~', '$1', $categoryList);
					echo '<ul id="categories-menu">';
						echo '<li class="cat-item cat-item-all"><a href="' . site_url() . '">All</a></li>' . $categoryList;
					echo '</ul>';
					?>

					<div class="search-box">
						<?php get_search_form(); ?>
					</div>
				</div>

				<div id="posts-list" class="m-all t-4of5 d-3of5">

					<?php
					if (have_posts()) : while (have_posts()) : the_post();
						get_template_part( 'content', get_post_format() );
					endwhile;
					else : ?>

						<article id="post-not-found" class="hentry cf">
							<header class="article-header">
								<h1><?php _e( 'Hmm... Nothing here, try again.', 'jcgtheme' ); ?></h1>
							</header>
							<section class="entry-content">
								<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'jcgtheme' ); ?></p>
							</section>
							<footer class="article-footer">
								<p><?php _e( 'This is the error message in the archive.php template.', 'jcgtheme' ); ?></p>
							</footer>
						</article>

					<?php endif; ?>

				</div> <?php // end #main ?>

			</div> <?php // end #content ?>

<?php get_footer(); ?>
