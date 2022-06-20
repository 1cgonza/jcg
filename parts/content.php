<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article" itemscope itemtype="https://schema.org/BlogPosting">
	<header class="article-header">
		<?php the_title( '<h1 class="entry-title cf">', '</a></h1>' ); ?>
		<time class="article-date"><p><?php the_time('l, M d, Y') ?></p></time>

		<div class="vcard author">By: <?php the_author(); ?></div>
	</header>

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
	</footer>
</article>

<?php comments_template(); ?>
