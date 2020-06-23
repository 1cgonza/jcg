<?php
	get_header();
	$postJS = '';

	if ( have_posts() ) :
		while ( have_posts() ) : the_post();
		get_template_part( 'parts/content', get_post_type() );
		$postJS = get_post_meta($post->ID, '_jcg_js', true);
		endwhile;
	else :
		get_template_part('parts/content', 'none');
	endif;

	if ( !empty($postJS) ) {
		echo '<script type="text/javascript">' . $postJS . '</script>';
	}
	get_footer();
