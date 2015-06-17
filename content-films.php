<?php
  $postMetaData = get_post_custom($post->ID);
  $iframe      = $postMetaData['url'][0];
  $releaseDate = $postMetaData['release_date'][0];
  $synopsis    = $postMetaData['synopsis'][0];
  $credits     = $postMetaData['credits'][0];
  $dateformatstring = 'Y';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article">

  <header class="film-header">
    <div id='video-container'>
      <?php echo apply_filters( 'the_content', $iframe ); ?>
      <img class="ratio" src="<?php echo get_template_directory_uri(); ?>/library/images/ratio.gif" />
    </div>
  </header>

  <section class="film-description cf">
    <h1 class="single-title film-title" itemprop="name"><?php the_title(); ?></h1>
    <?php
    $date = new DateTime($releaseDate);
    ?>
    <h3 class="no-margin" itemprop="dateCreated"><?php echo date_format($date, 'Y'); ?></h3>
    <div class="film-synopsis" itemprop="description"><?php echo $synopsis; ?></div>
  </section>


  <?php
    /*==========  AWARDS  ==========*/
    $awards_args = array(
      'post_type' => 'cv_meta',
      'tax_query' => array(
        array(
          'taxonomy' => 'cv_cat',
          'field'    => 'slug',
          'terms'    => 'awards'
        )
      ),
      'orderby'        => 'meta_value_num',
      'posts_per_page' => '-1',
      'meta_key'       => 'date_start',
      'order'          => 'DESC',
      'meta_query'     => array(
        array(
          'key'     => 'related_films',
          'value'   => '"' . $post->ID . '"',
          'compare' => 'LIKE'
        )
      )
    );
    $awards = new WP_Query( $awards_args );
    if ( $awards->have_posts() ) :
  ?>

  <section id="awards">
    <?php
      while ($awards->have_posts() ) :
        $awards->the_post();
        $awardMetaData    = get_post_custom($post->ID);
        $givenBy          = get_the_title();
        $unixtimestamp    = strtotime( $awardMetaData['date_start'][0] );
        $websiteURL       = $awardMetaData['website_url'][0];
        $awardType        = $awardMetaData['award_type'][0];
        $awardTitle       = $awardMetaData['award_title'][0];
        $awardCountry     = $awardMetaData['country'][0];
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
  <?php
    endif;
    wp_reset_postdata();
  ?>

  <section id="credits" class="m-all t-all d-1of2 ld-1of2">
    <h2 class="column-title">Credits</h2>
    <div class="wrap">
      <?php echo apply_filters( 'the_content', $credits ); ?>
    </div>
  </section>

  <?php
    /*==========  OFFICIAL SELECTIONS  ==========*/
    $festivals_args = array(
      'post_type' => 'cv_meta',
      'tax_query' => array(
        array(
          'taxonomy' => 'cv_cat',
          'field'    => 'slug',
          'terms'    => 'official-selection'
        )
      ),
      'orderby'        => 'meta_value_num',
      'posts_per_page' => '-1',
      'meta_key'       => 'date_start',
      'order'          => 'DESC',
      'meta_query'     => array(
        array(
          'key'     => 'related_films',
          'value'   => '"' . $post->ID . '"',
          'compare' => 'LIKE'
        )
      )
    );
    $selection = new WP_Query( $festivals_args );
    if ( $selection->have_posts() ) :
  ?>

  <section id="screenings" class="m-all t-all d-1of2 ld-1of2">
      <h2 class="column-title">Official Selections</h2>
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
  <?php
    endif;
    wp_reset_postdata();
  ?>

</article>