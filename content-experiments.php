<?php
  $postMetaData     = get_post_custom($post->ID);
  $link             = $postMetaData['url'][0] ? $postMetaData['url'][0] : '';
  $releaseDate      = $postMetaData['release_date'][0] ? $postMetaData['release_date'][0] : '';
  $synopsis         = $postMetaData['synopsis'][0] ? $postMetaData['synopsis'][0] : '';
  $credits          = $postMetaData['credits'][0] ? $postMetaData['credits'][0] : '';
  $styleClass       = !empty( $postMetaData['excerpt_style'][0] ) ? 'entry-style-' . $postMetaData['excerpt_style'][0] : '';
  $styles           = '';
  $articleStyles    = '';

  if ( $postMetaData['background_image'][0] && $postMetaData['background_overlay'][0] ) {
    $styles = 'background-image:url(' . $postMetaData['background_image'][0] . ');';
    $styles .= 'background-color:' . $postMetaData['background_overlay'][0] . ';';
    $styles .= 'background-size:cover;';
    $styles .= 'background-blend-mode: multiply;';
  }

  if ( !empty($styles) && $postMetaData['embed_video'][0] == 0 ) {
    $articleStyles = 'style="' . $styles . '"';
  }

  $dateformatstring = 'Y';

  /*==========  OFFICIAL SELECTIONS  ==========*/
  $selection = jcg_query_cv_posts($post->ID, 'official-selection');
  $selectionCheck = $selection->have_posts();

  /*==========  AWARDS  ==========*/
  $awards = jcg_query_cv_posts($post->ID, 'awards');
  $awardsCheck = $awards->have_posts();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article">

  <header class="project-header">
  <?php if ($postMetaData['embed_video'][0] == 1) : ?>
    <div id='video-container'>
      <?php echo apply_filters( 'the_content', $link ); ?>
      <img class="ratio" src="<?php echo get_template_directory_uri(); ?>/library/images/ratio.gif" />
    </div>
  <?php endif; ?>
  </header>

  <section class="project-description cf <?php echo $styleClass; ?>" <?php echo $articleStyles; ?>>
    <h1 class="single-title project-title" itemprop="name"><?php the_title(); ?></h1>
    <?php
    $date = new DateTime($releaseDate);
    ?>
    <h3 class="no-margin" itemprop="dateCreated"><?php echo date_format($date, 'Y'); ?></h3>
    <div class="project-synopsis" itemprop="description"><?php echo $synopsis; ?></div>
    <?php if ($postMetaData['embed_video'][0] == 0) : ?>
      <a class="launch-btn" href="<?php echo $link; ?>" target="_blank">Launch</a>
    <?php endif; ?>
  </section>

  <?php if ($awardsCheck) : ?>

  <section id="awards">
    <?php
      while ($awards->have_posts() ) :
        $awards->the_post();
        $awardMetaData = get_post_custom($post->ID);
        $givenBy       = get_the_title();
        $unixtimestamp = strtotime( $awardMetaData['date_start'][0] );
        $websiteURL    = $awardMetaData['website_url'][0];
        $awardType     = $awardMetaData['award_type'][0];
        $awardTitle    = $awardMetaData['award_title'][0];
        $awardCountry  = $awardMetaData['country'][0];
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

  <section id="credits" class="m-all t-all d-1of2 ld-1of2 <?php echo !$selectionCheck ? 'no-exhibitions' : ''; ?>">
    <h2 class="column-title">Credits</h2>
    <div class="wrap">
      <?php echo apply_filters( 'the_content', $credits ); ?>
    </div>
  </section>

  <?php if ($selectionCheck) : ?>

  <section id="exhibitions" class="m-all t-all d-1of2 ld-1of2">
    <h2 class="column-title">Exhibitions</h2>
    <table class="wrap">
      <?php
        while ($selection->have_posts() ) :
          $selection->the_post();
          $selectionMetaData = get_post_custom($post->ID);
          $unixtimestamp     = strtotime( $selectionMetaData['date_start'][0] );
          $websiteURL        = $selectionMetaData['website_url'][0];
          $venue             = get_the_title();
          $selectionCountry  = $selectionMetaData['country'][0];
      ?>
        <tr>
          <td class="year"><?php echo date_i18n($dateformatstring, $unixtimestamp); ?></td>
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

</article>