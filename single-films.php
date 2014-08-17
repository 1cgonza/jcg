<?php get_header();

$videoUrl = get_field('url');
$releaseDate = DateTime::createFromFormat('Y-m-d', get_field('release_date'));
?>

    <div id="content" class="">

      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article">
        <header class="film-header">
          <?php echo wp_oembed_get($videoUrl); ?>
        </header>

        <section class="film-description cf">
          <h1 class="single-title film-title" itemprop="name"><?php the_title(); ?></h1>
          <h3 class="no-margin" itemprop="dateCreated"><?php echo $releaseDate->format('Y'); ?></h3>
          <div class="film-synopsis" itemprop="description"><?php the_field('synopsis'); ?></div>
        </section>


        <?php
        /*------------------------------------

                        AWARDS

        --------------------------------------*/
        $awardsArgs = array(
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
              'value'   => get_the_ID(),
              'compare' => 'LIKE'
            )
          )
        );

        $awards = new WP_Query( $awardsArgs );

        if ( $awards->have_posts() ) : ?>

        <section id="awards">

          <?php while ( $awards->have_posts() ) : $awards->the_post();

            /*---------------------------------------------------------------
                       GET LABEL NAME FROM THE CUSTOM FIELD OBJECT
            -----------------------------------------------------------------*/
            // Get the information contained in the custom field object into a variable. DEBUG: var_dump($field);
            $awardTypeObject = get_field_object('award_type');
            // Now we check which "Award Type" option is selected. Ex: Honour or Winner
            $awardType       = get_field('award_type');
            // Get the label from the array of options in the field_object.
            $awardLabel      = $awardTypeObject['choices'][ $awardType ];

            /*---------------------------------------------------------------
                                       AWARD VARIABLES
            -----------------------------------------------------------------*/
            $eventStartDate = DateTime::createFromFormat('Ymd', get_field('date_start'));
            $websiteURL     = get_field('website_url');
            $awardTitle     = get_field('award_title');
            $eventCountry   = get_field('country');

            /*---------------------------------------------------------------
                                        AWARD ITEM
            -----------------------------------------------------------------*/
            $awardItem = '<div class="award-item ' . $awardType . '">';
            $awardItem .= '<div class="award-item-text">';
            $awardItem .= '<h2>' . $awardLabel . '</h2>';
            $awardItem .= '<p class="award-title">' . $awardTitle . '</p>';
            $awardItem .= '<p class="award-festival-name">';
            if ( $websiteURL ) {
              $awardItem .= '<a title="' . get_the_title() . '" href="' . $websiteURL . '" target="_blank">' . get_the_title() . '</a>';
            } else {
              $awardItem .= get_the_title();
            }
            $awardItem .= '</p>';
            $awardItem .= '<p class="award-festival-country">' . $eventCountry . '</p>';
            $awardItem .= '<h2 class="award-festival-year">' . $eventStartDate->format('Y') . '</h2>';
            $awardItem .= '</div>'; // .award-item-text
            $awardItem .= '</div>'; // .award-item

            echo $awardItem;

          endwhile; ?>

        </section>

        <?php endif; wp_reset_postdata(); ?>

        <section id="credits" class="m-1of2 t-1of2 d-1of2">
          <h2 class="title">Credits</h2>

          <div class="wrap">
            <?php the_field('credits'); ?>
          </div>
        </section><!--
        --><?php
        /*------------------------------------

                  OFFICIAL SELECTIONS

        --------------------------------------*/
        $festivalsArgs = array(
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
              'value'   => '"' . get_the_ID() . '"',
              'compare' => 'LIKE'
            )
          )
        );

        $oficialSelection = new WP_Query( $festivalsArgs );

        if ( $oficialSelection->have_posts() ) :
          $beforeOficialSelection = '<section id="screenings" class="m-1of2 t-1of2 d-1of2">';
          $beforeOficialSelection .= '<h2 class="title">Official Selections</h2>';
          $beforeOficialSelection .= '<table class="wrap">';

          echo $beforeOficialSelection;

          while ($oficialSelection->have_posts() ) : $oficialSelection->the_post();
            $eventStartDate = DateTime::createFromFormat('Ymd', get_field('date_start'));
            $websiteURL     = get_field('website_url');
            $eventCountry   = get_field('country');

            $oficialSelectionItem = '<tr>';
            $oficialSelectionItem .= '<td class="year">' . $eventStartDate->format('Y') . '</td>';
            $oficialSelectionItem .= '<td class="festival-name">';
            if ( $websiteURL ) {
              $oficialSelectionItem .= '<a title="' . get_the_title() . '" href="' . $websiteURL . '" target="_blank">' . get_the_title() . '</a>';
            } else {
              $oficialSelectionItem .= get_the_title();
            }
            $oficialSelectionItem .= '</td>';
            $oficialSelectionItem .= '<td class="country">' . $eventCountry . '</td>';
            $oficialSelectionItem .= '</tr>';

            echo $oficialSelectionItem;
          endwhile;

          $afterOficialSelection = '</table>';
          $afterOficialSelection .= '</section>';

          echo $afterOficialSelection;

        endif; wp_reset_postdata(); ?>

        <section id="process">

        </section>

        <footer class="article-footer">

        </footer>

        <?php comments_template(); ?>

      </article>

      <?php endwhile; else : ?>

      <article id="post-not-found" class="hentry cf">
        <header class="article-header">
          <h1><?php _e( 'Oops, Post Not Found!', 'jcgtheme' ); ?></h1>
        </header>
        <section class="entry-content">
          <p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'jcgtheme' ); ?></p>
        </section>
        <footer class="article-footer">
          <p><?php _e( 'This is the error message in the single-custom_type.php template.', 'jcgtheme' ); ?></p>
        </footer>
      </article>

      <?php endif; ?>

    </div> <?php // #content ?>

<?php get_footer(); ?>
