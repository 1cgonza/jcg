<?php
/*
 Template Name: About
*/
get_header(); ?>

      <div id="content" class="about m-all t-4of5 d-9of10 last-col">

      <?php

      /*==========  BIO  ==========*/

      $externalLinks = array (
        'GitHub'   => 'https://github.com/1cgonza',
        'Vimeo'    => 'http://www.vimeo.com/juancgonzalez',
        'Facebook' => 'https://www.facebook.com/juancgonza',
        'Flickr'   => 'https://www.flickr.com/photos/juancgonzalez',
        'LinkedIn' => 'https://www.linkedin.com/in/juancgonza',
        'IMDB'     => 'http://www.imdb.com/name/nm3645383/',
        'YouTube'  => 'https://www.youtube.com/user/juankmilogonzalez',
        'Twitter'  => 'https://twitter.com/1cgonza'
      );

      $authorName = get_the_author_meta( 'display_name', 1 );
      $bio = get_the_author_meta( 'description', 1 );

      $profile = '<div id=profile class="cf">';
        $profile .= '<div id="portrait"><img src="http://localhost/moebius/juan/wp-content/uploads/sites/5/2014/11/Juan-Camilo-Gonzalez-photo-by-Abby-Rose.jpg"></div>';


        $profile .= '<div id="about-info">';

          $profile .= '<h1>' . $authorName . '</h1>';
          $profile .= '<ul id="social-links">';
          foreach ($externalLinks as $vendor => $url) {
            $profile .= '<li><a class="' . strtolower($vendor) . ' social-icon" href="' . $url . '" target="_blank">' . $vendor . '</a></li>';
          }
          $profile .= '</ul>'; // end #links

        $profile .= '</div>'; //end #about-info
      $profile .= '</div>'; // end #profile

      echo $profile;

      /*==========  BIO  ==========*/

      echo '<p>' . $bio . '</p>';


      /*==========  EDUCATION  ==========*/

      $educationArgs = array (
        'post_type'      => 'cv_meta',
        'cv_cat'         => 'education',
        'posts_per_page' => -1,
        'meta_key'       => 'date_start',
        'orderby'        => 'meta_value_num',
        'order'          => 'DESC'
      );

      $educationQuery = new WP_Query( $educationArgs );

      if ( $educationQuery->have_posts() ) :

        echo '<h2>Education</h2>';

        while ( $educationQuery->have_posts() ) : $educationQuery->the_post();

        $websiteURL       = get_field('website_url');
        $dateformatstring = 'Y';
        $startUNIX        = strtotime( get_field('date_start') );
        $endUNIX          = strtotime( get_field('date_end') );
        $degree           = get_field('degree');
        $institution      = get_field('institution');
        $city             = get_field('city');
        $country          = get_field('country');
        $startYear        = date_i18n($dateformatstring, $startUNIX);
        $endYear          = date_i18n($dateformatstring, $endUNIX);

        $educationItem = '<div class="education-item">';

          $educationItem .= '<div class="years">' . $startYear . ' - ' . $endYear . '</div>';

          $educationItem .= '<div class="education-info">';
            $educationItem .= '<p><strong>' . $degree . '</strong> <a href="' . $websiteURL . '" target="_blank">' . get_the_title() . '</a></p>';
            $educationItem .= '<p>' . $institution . ', ' . $city . ', ' . $country . '<p>';
          $educationItem .= '</div>'; // end .education-info

        $educationItem .= '</div>'; // end .education-item

        echo $educationItem;

        endwhile; wp_reset_postdata();

      endif;
      ?>

      </div> <?php // end #content ?>

<?php get_footer(); ?>