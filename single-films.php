<?php get_header(); ?>

      <div id="content" class="m-all t-4of5 d-9of10 last-col">

          <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article">

              <header class="film-header">
                <div id='video-container'>
                  <?php the_field('embed_code'); ?>
                  <img class="ratio" src="<?php echo get_template_directory_uri(); ?>/library/images/ratio.gif" />
                </div>
              </header>

              <section class="film-description cf">
                <h1 class="single-title film-title" itemprop="name"><?php the_title(); ?></h1>
                <h3 class="no-margin" itemprop="dateCreated"><?php the_field('year'); ?></h3>
                <div class="film-synopsis" itemprop="description"><?php the_field('synopsis'); ?></div>
              </section>


              <?php
                /*------------------------------------

                                AWARDS

                --------------------------------------*/
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
                      'value'   => '"' . get_the_ID() . '"',
                      'compare' => 'LIKE'
                    )
                  )
                );
                $awards = new WP_Query( $awards_args );
                if ( $awards->have_posts() ) {
                  echo '<section id="awards">';

                    while ($awards->have_posts() ) {
                      $awards->the_post();
                      $dateformatstring = "Y";
                      $unixtimestamp = strtotime(get_field('date_start'));
                      $website_url = get_field('website_url');

                      // Get the label name because using the get_field will only show the slug.

                      // Call all the information contained in the custom field. It can be echoed using print_r($field);
                      $field = get_field_object('award_type');
                      // Now we check which option is selected
                      $value = get_field('award_type');
                      // Selects the label in the array
                      $awardLabel = $field['choices'][ $value ];

                      echo '<div class="award-item ' . get_field('award_type') . '">';
                        echo '<div class="award-item-text">';
                          echo '<h2>' . $awardLabel . '</h2>';
                          echo '<p class="award-title">' . get_field('award_title') . '</p>';
                          echo '<p class="award-festival-name">';
                            if ( $website_url ) {
                              echo '<a title="' . get_the_title() . '" href="' . get_field('website_url') . '" target="_blank">' . get_the_title() . '</a>';
                            } else {
                              echo get_the_title();
                            }
                          echo '</p>';
                          echo '<p class="award-festival-country">' . get_field('country') . '</p>';
                          echo '<h2 class="award-festival-year">' . date_i18n($dateformatstring, $unixtimestamp) . '</h2>';
                        echo '</div>';
                      echo '</div>';
                    }
                  echo '</section>';
                }
                wp_reset_postdata();
              ?>

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
                      'value'   => '"' . get_the_ID() . '"',
                      'compare' => 'LIKE'
                    )
                  )
                );
                $selection = new WP_Query( $festivals_args );
                if ( $selection->have_posts() ) {
                  echo '<section id="screenings" class="m-1of2 t-1of2 d-1of2">';
                    echo '<h2 class="title">Official Selections</h2>';
                    echo '<table class="wrap">';

                    while ($selection->have_posts() ) {
                      $selection->the_post();
                      $dateformatstring = "Y";
                      $unixtimestamp = strtotime(get_field('date_start'));
                      $website_url = get_field('website_url');

                      echo '<tr>';
                        echo '<td class="year">' . date_i18n($dateformatstring, $unixtimestamp) . '</td>';
                        echo '<td class="festival-name">';
                          if ( $website_url ) {
                            echo '<a title="' . get_the_title() . '" href="' . get_field('website_url') . '" target="_blank">' . get_the_title() . '</a>';
                          } else {
                            echo get_the_title();
                          }
                        echo '</td>';
                        echo '<td class="country">' . get_field('country') . '</td>';
                      echo '</tr>';
                    }

                    echo '</table>';
                  echo '</section>';
                }
                wp_reset_postdata();
              ?>


              <footer class="article-footer">

              </footer>

              <?php comments_template(); ?>

            </article>

          <?php endwhile; ?>

          <?php else : ?>

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

      </div>

<?php get_footer(); ?>
