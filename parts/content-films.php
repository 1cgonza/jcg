<?php
	$postID           = $post->ID;
	$iframe           = get_post_meta($postID, '_jcg_url', true);
	$releaseDate      = get_post_meta($postID, '_jcg_release_date', true);
	$synopsis         = get_post_meta($postID, '_jcg_synopsis', true);
	$credits          = get_post_meta($postID, '_jcg_credits', true);
	$dateformatstring = 'Y';
	$awards           = jcg_query_cv_posts($postID, 'awards');
  $selection        = jcg_query_cv_posts($postID, array('exhibitions', 'film-exhibition') );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article">
	<header class="project-header">
		<div id='video-container'>
      <?php echo apply_filters( 'the_content', $iframe ); ?>
      <img class="ratio" src="<?php echo get_template_directory_uri(); ?>/src/images/ratio.gif" />
		</div>
	</header>

	<section class="project-description cf">
		<h1 class="single-title film-title" itemprop="name"><?php the_title(); ?></h1>
		<h3 class="no-margin" itemprop="dateCreated"><?php echo date_i18n($dateformatstring, $releaseDate); ?></h3>
		<div class="project-synopsis" itemprop="description"><?php echo $synopsis; ?></div>
	</section>

	<?php if ( $awards->have_posts() ) : ?>

	<section id="awards">
		<?php
		while ($awards->have_posts() ) :
      $awards->the_post();
      $postID           = $post->ID;
			$givenBy          = get_the_title();
			$unixtimestamp    = get_post_meta($postID, '_cv_date_start', true);
			$websiteURL       = get_post_meta($postID, '_cv_website_url', true);
			$awardType        = get_post_meta($postID, '_cv_award_type', true);
			$awardTitle       = get_post_meta($postID, '_cv_award_title', true);
			$awardCountry     = get_post_meta($postID, '_cv_country', true);
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
        <h2 class="award-festival-year"><?php echo date_i18n($dateformatstring, $unixtimestamp); ?></h2>
      </div>
		</div>
		<?php endwhile; ?>
	</section>

	<?php endif; wp_reset_postdata(); ?>

	<section id="credits" class="m-all t-all d-1of2 ld-1of2">
		<h2 class="column-title">Credits</h2>
		<div class="wrap">
		<?php echo apply_filters( 'the_content', $credits ); ?>
		</div>
	</section>

	<?php if ( $selection->have_posts() ) : ?>

	<section id="screenings" class="m-all t-all d-1of2 ld-1of2">
		<h2 class="column-title">Official Selections</h2>

		<table class="wrap">
		<?php
			while ($selection->have_posts() ) :
			$selection->the_post();
			$unixtimestamp     = get_post_meta($post->ID, '_cv_date_start', true);
			$websiteURL        = get_post_meta($post->ID, '_cv_website_url', true);
			$venue             = get_the_title();
      $selectionCountry  = get_post_meta($post->ID, '_cv_country', true);
		?>
		<tr>
			<td class="year"><?php echo date_i18n($dateformatstring, $unixtimestamp); ?></td>
			<td class="festival-name">
        <?php if ($websiteURL) : ?>
          <a title="<?php echo $venue; ?>" href="<?php echo $websiteURL; ?>" target="_blank"><?php echo $venue; ?></a>
        <?php else : echo $venue; endif; ?>
			</td>
			<td class="country"><?php echo $selectionCountry; ?></td>
		</tr>
		<?php endwhile; ?>
		</table>
	</section>

	<?php endif; wp_reset_postdata(); ?>

</article>
