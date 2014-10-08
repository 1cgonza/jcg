<?php get_header(); ?>

			<div id="content" class="m-all t-4of5 d-9of10 last-col">

				<div id="description-box">
					<h1 class="archive-title"><span><?php _e( 'Search Results for:', 'jcgtheme' ); ?></span> <?php echo esc_attr(get_search_query()); ?></h1>
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
					// Render categories
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
								<h1><?php _e( 'Sorry, no results for "' . esc_attr(get_search_query()) . '".', 'jcgtheme' ); ?></h1>
							</header>
							<section class="entry-content">
								<p><?php _e( 'Try your search again.', 'jcgtheme' ); ?></p>
							</section>
						</article>

					<?php endif; ?>

				</div> <?php // end #posts-list ?>

				<?php //get_sidebar(); ?>

			</div> <?php // end #content ?>

<?php get_footer(); ?>
