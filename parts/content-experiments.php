<?php
	$dateFormat   = 'Y';
	$link         = get_post_meta( $post->ID, '_jcg_url',           true );
	$releaseDate  = get_post_meta( $post->ID, '_jcg_release_date',  true );
	$synopsis     = get_post_meta( $post->ID, '_jcg_synopsis',      true );
	$credits      = get_post_meta( $post->ID, '_jcg_credits',       true );
	$headerStyle  = get_post_meta( $post->ID, '_jcg_header_style',  true );
	$bgImage      = get_post_meta( $post->ID, '_jcg_header_background_image',   true );
	$bgOverlay    = get_post_meta( $post->ID, '_jcg_header_background_overlay', true );
	$embedCheck   = get_post_meta( $post->ID, '_jcg_embed_video',  1 );
  $styleClass    = !empty($headerStyle) ? 'entry-style-' . $headerStyle : '';
	$articleStyles = '';

	if ($bgImage && $bgOverlay) {
		$styles = 'background-image:url(' . $bgImage . ');';
		$styles .= 'background-color:' . $bgOverlay . ';';
		$styles .= 'background-size:cover;';
		$styles .= 'background-blend-mode: multiply;';

		if (empty($embedCheck)) {
      $articleStyles = 'style="' . $styles . '"';
		}
	}

	/*==========  OFFICIAL SELECTIONS  ==========*/
	$selection = jcg_query_cv_posts($post->ID, array('exhibitions', 'film-exhibition') );
	$selectionCheck = $selection->have_posts();

	/*==========  AWARDS  ==========*/
	$awards = jcg_query_cv_posts($post->ID, 'awards');
	$awardsCheck = $awards->have_posts();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article">

	<header class="project-header">
	<?php if ($embedCheck == 'on') : ?>
		<div id='video-container'>
		<?php if ( !empty($link) ) {
			echo apply_filters( 'the_content', $link );
		} ?>

		<img class="ratio" src="<?php echo get_template_directory_uri(); ?>/src/images/ratio.gif" />
		</div>
	<?php endif; ?>
	</header>

	<section class="project-description cf <?php echo $embedCheck ? '' : $styleClass; ?>" <?php echo $articleStyles; ?>>
		<h1 class="single-title project-title" itemprop="name"><?php the_title(); ?></h1>

		<?php if ( !empty($releaseDate) ) : ?>
		<h3 class="no-margin" itemprop="dateCreated"><?php echo date_i18n('Y', $releaseDate); ?></h3>
		<?php endif; ?>

		<?php if ( !empty($synopsis) ) : ?>
		<div class="project-synopsis" itemprop="description"><?php echo $synopsis; ?></div>
		<?php endif; ?>

		<?php if ( !empty($link) && empty($embedCheck)) : ?>
		<a class="launch-btn" href="<?php echo $link; ?>" target="_blank">Launch</a>
		<?php endif; ?>
	</section>

	<?php if ($awardsCheck) : ?>

	<section id="awards">
		<?php
    while ($awards->have_posts() ) : $awards->the_post();
      $postID = $post->ID;
			$givenBy       = get_the_title();
			$unixtimestamp = get_post_meta($post->ID, '_cv_date_start', true);
			$websiteURL    = get_post_meta($post->ID, '_cv_website_url', true);
			$awardType     = get_post_meta($post->ID, '_cv_award_type', true);
			$awardTitle    = get_post_meta($post->ID, '_cv_award_title', true);
			$awardCountry  = get_post_meta($post->ID, '_cv_country', true);
		?>
		<div class="award-item <?php echo $awardType; ?>">
			<div class="award-item-text">
			<h2><?php echo ucfirst($awardType); ?></h2>
			<p class="award-title"><?php echo $awardTitle; ?></p>
			<p class="award-festival-name">
				<?php if ( !empty($websiteURL) ) { ?>
				<a href="<?php echo $websiteURL; ?>" target="_blank"><?php echo $givenBy; ?></a>
				<?php } else {
				echo $givenBy;
				} ?>
			</p>
			<p class="award-festival-country"><?php echo $awardCountry; ?></p>
			<h2 class="award-festival-year"><?php echo date_i18n($dateFormat, $unixtimestamp); ?></h2>
			</div>
		</div>
		<?php endwhile; ?>
	</section>
	<?php endif; wp_reset_postdata(); ?>

	<?php if ( !empty($credits) ) : ?>
	<section id="credits" class="m-all t-all d-1of2 ld-1of2 <?php echo !$selectionCheck ? 'no-exhibitions' : ''; ?>">
		<h2 class="column-title">Credits</h2>
		<div class="wrap">
		<?php echo apply_filters( 'the_content', $credits ); ?>
		</div>
	</section>
	<?php endif; ?>

	<?php if ($selectionCheck) : ?>

	<section id="exhibitions" class="m-all t-all d-1of2 ld-1of2">
		<h2 class="column-title">Exhibitions</h2>
		<table class="wrap">
		<?php
      while ($selection->have_posts() ) : $selection->the_post();
      $postID = $post->ID;
			$unixtimestamp     = get_post_meta( $postID, '_cv_date_start', true );
			$websiteURL        = get_post_meta( $postID, '_cv_website_url', true );
			$venue             = get_the_title();
			$selectionCountry  = get_post_meta( $postID, '_cv_country', true );
		?>
			<tr>
			<td class="year"><?php echo date_i18n($dateFormat, $unixtimestamp); ?></td>
			<td class="festival-name">
				<?php if ( !empty($websiteURL) ) { ?>
				<a title="<?php echo $venue; ?>" href="<?php echo $websiteURL; ?>" target="_blank"><?php echo $venue; ?></a>
				<?php } else {
				echo $venue;
				} ?>
			</td>
			<td class="country"><?php echo $selectionCountry; ?></td>
			</tr>
		<?php endwhile; ?>
		</table>
	</section>
	<?php endif; wp_reset_postdata(); ?>

	<?php if ( !empty($post->post_content) ) : ?>
		<section id="documentation" class="entry-content cf">
		<h2>Documentation</h2>
		<?php the_content(); ?>
		</section>
	<?php endif; ?>

</article>
