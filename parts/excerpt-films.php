<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
	<header class="article-header">
		<div class="post-image">
		<?php if ( has_post_thumbnail() ) : ?>
			<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('jcg-1300x325'); ?></a>
		<?php else : ?>
			<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
			<img src="http://placehold.it/800x200/ECECEC/d2d2d2?text=%20" alt="<?php the_title(); ?>" />
			</a>
		<?php endif; ?>
		</div>
	</header>

	<section class="entry-excerpt-title m-all t-all d-2of5 ld-2of5">
		<?php
    $releaseDate = get_post_meta($post->ID, '_jcg_release_date', true);
		$year = date_i18n('Y', $releaseDate);;
		the_title( '<h2 class="excerpt-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', ' (' . $year . ')</a></h2>' );
		?>
	</section>

	<section class="entry-excerpt m-all t-all d-3of5 ld-3of5">
		<?php
		$summary = get_post_meta($post->ID, '_jcg_synopsis', true);
		if ( !empty($summary) ) {
			echo apply_filters('the_content', $summary);
		}
		?>
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
	</footer>
</article>
