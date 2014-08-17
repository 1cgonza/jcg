<?php get_header(); ?>

    <div id="content" class="about">
      <?php
        /*------------------------------------------
                              BIO
        --------------------------------------------*/
      ?>
      <h1 class="about-name"><?php echo get_the_author_meta( 'display_name', 1 ); ?></h1>
      <div class="about-bio"><?php echo get_the_author_meta( 'description', 1 ); ?></div>
      <?php
        /*------------------------------------------
                          EDUCATION
        --------------------------------------------*/
      ?>
      <h2>Education</h2>
      <?php
      $educationCv = array(
        'post_type' => 'cv_meta',
        'tax_query' => array(
          array(
            'taxonomy' => 'cv_cat',
            'field'    => 'slug',
            'terms'    => 'education'
          )
        ),
        'orderby'        => 'meta_value_num',
        'posts_per_page' => '-1',
        'meta_key'       => 'date_start',
        'order'          => 'DESC'
      );
      $education = new WP_Query( $educationCv );
      if ( $education->have_posts() ) : while( $education->have_posts() ) : $education->the_post();
        $dateStart   = date_i18n( 'Y', strtotime( get_field('date_start') ) );
        $dateEnd     = date_i18n( 'Y', strtotime( get_field('date_end') ) );
        $websiteURL  = get_field('website_url');
        $city        = get_field('city');
        $country     = get_field('country');
        $degree      = get_field('degree');
        $institution = get_field('institution');

        echo '<div class="education-item">';
        echo '<div class="education-degree">' . $degree . '<br/>| ' . $dateStart . ' - ' . $dateEnd . ' | </div>';
        if ( $city == $country ) {
          echo '<div class="education-institution"><a href="' . $websiteURL . '">' . get_the_title() . '</a>' . '<br/>' . $institution . '<br/>' . $country . '</div>';
        } else {
          echo '<div class="education-institution"><a href="' . $websiteURL . '">' . get_the_title() . '</a>' . '<br/>' . $institution . '<br/>' . $city . ', ' . $country . '</div>';
        }
        echo '</div>'; // .education-item
      endwhile; endif; wp_reset_postdata();
      ?>
    </div> <?php // end #content ?>
<?php get_footer(); ?>