<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article" itemscope itemtype="https://schema.org/BlogPosting">
	<header class="article-header">
		<?php the_title( '<h1 class="entry-title cf">', '</h1>' ); ?>
	</header>

	<section class="entry-content cf">
		<?php the_content(); ?>
	</section>

	<footer class="entry-footer">
	</footer>
</article>
