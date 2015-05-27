<?php
/*
 Template Name: About
*/
get_header(); ?>

    <?php
    $aboutData = (array)get_option('jcg_about_options');
    $contentSeparator = ', ';
    $dateformatstring = 'Y';

    $profilePic = get_the_post_thumbnail($post->ID, 'large');
    $authorName = get_bloginfo('name');
    $bio        = !empty( $aboutData['bio'] )  ? apply_filters( 'the_content', $aboutData['bio'] ) : '';

    /*========================================
    =            HEADER - PROFILE            =
    ========================================*/
    $profile = '<div id=profile class="cf">';
      $profile .= '<div id="portrait">' . $profilePic . '</div>';

      $profile .= '<div id="about-info">';
        $profile .= '<h1>' . $authorName . '</h1>';
        $profile .= jcg_contact_info();

      $profile .= '</div>'; //end #about-info
    $profile .= '</div>'; // end #profile

    echo $profile;

    /*-----  End of HEADER - PROFILE  ------*/

    /*===============================
    =         ABOUT CONTENT         =
    ===============================*/
    $about = '<div id="about-content">';

      /*==========  BIO  ==========*/
      $about .= '<div id="bio">' . $bio . '</div>';

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

        $about .= '<h2>Education</h2>';
        $about .= '<table class="jcg-cv-table"><tbody>';

        while ( $educationQuery->have_posts() ) : $educationQuery->the_post();
          $postData = get_post_custom($post->ID);
          $educationContent = [];

          /*==========  DATE  ==========*/
          $date = '';
          if ( !empty($postData['date_start'][0]) ) {
            $startUNIX = strtotime( $postData['date_start'][0] );
            $startYear = date_i18n($dateformatstring, $startUNIX);

            $datesRange = $startYear;

            if ( !empty($postData['date_end'][0]) ) {
              $endUNIX = strtotime( $postData['date_end'][0] );
              $endYear = date_i18n($dateformatstring, $endUNIX);

              $datesRange .= ' - ' . $endYear;
            }

            $date = $datesRange;
          }

          /*==========  DEGREE TYPE  ==========*/
          $degreeType = '';
          if ( !empty($postData['degree'][0]) ) {
            $degreeType = '<span class="education-type">' . $postData['degree'][0] . '</span>';
          }

          /*==========  DEGREE BY  ==========*/
          $url = $postData['website_url'][0];
          $title = get_the_title();
          $degreeBy = !empty($url) ? '<a href="' . $url . '" target="_blank">' . $title . '</a>' : $title;
          $educationContent['degree_by'] = '<span class="education-intitution">' . $degreeBy . '</span>';

          /*==========  INSTITUTION  ==========*/
          if ( !empty($postData['institution'][0]) ) {
            $educationContent['institution'] = '<span class="education-intitution">' . $postData['institution'][0] . '</span>';
          }

          /*==========  PLACE  ==========*/
          $city    = !empty( $postData['city'][0] )    ? $postData['city'][0]    : NULL;
          $country = !empty( $postData['country'][0] ) ? $postData['country'][0] : NULL;

          if ( strcmp($city, $country) !== 0 ) {
            $educationContent['place'] = '<span class="award-place">' . $city . $contentSeparator . $country . '</span>';
          } else {
            $educationContent['place'] = '<span class="award-place">' . $country . '</p>';
          }

          $educationItem = '<tr class="jcg-cv-item education-item">';
            $educationItem .= '<td class="jcg-cv-item-col1 years">' . $date . '</td>';
            $educationItem .= '<td class="jcg-cv-item-col2 education-info">';
              $educationItem .= $degreeType;
              if ( !empty($educationContent) ) {
                $educationItem .= implode($contentSeparator, $educationContent);
              }
            $educationItem .= '</td>'; // end .jcg-cv-item-col2
          $educationItem .= '</tr>'; // end .jcg-cv-item

        $about.= $educationItem;

        endwhile; wp_reset_postdata();
        $about .= '</tbody></table>';
      endif;

      /*==========  AWARDS  ==========*/
      $awardsArgs = array (
        'post_type'      => 'cv_meta',
        'cv_cat'         => 'awards',
        'posts_per_page' => -1,
        'meta_key'       => 'date_start',
        'orderby'        => 'meta_value_num',
        'order'          => 'DESC'
      );
      $awardsQuery = new WP_Query( $awardsArgs );

      if ( $awardsQuery->have_posts() ) :
        $termAwards = get_term_by('name', 'awards', 'cv_cat');

        $about .= '<h2>Awards</h2>';
        $about .= '<table class="jcg-cv-table"><tbody>';
        while ( $awardsQuery->have_posts() ) : $awardsQuery->the_post();
          $postData  = get_post_custom($post->ID);
          $postTerms = get_the_terms($post->ID, 'cv_cat');

          $awardContent = [];

          /*==========  DATE  ==========*/
          $date = '';
          if ( !empty($postData['date_start'][0]) ) {
            $startUNIX = strtotime( $postData['date_start'][0] );
            $startYear = date_i18n($dateformatstring, $startUNIX);

            $date = $startYear;
          }

          /*==========  AWARD TYPE  ==========*/
          $awardType = NULL;
          foreach ($postTerms as $term) {
            if ( term_is_ancestor_of($termAwards->term_id, $term->term_id,  'cv_cat') ) {
              $awardType = '<span class="award-type award-type-' . $term->slug . '">' . $term->name . '</span>';
            }
          }

          /*==========  AWARD TITLE  ==========*/
          if ( !empty($postData['award_title'][0]) ) {
            $awardContent['award_title'] = '<span class="award-title">' . $postData['award_title'][0] . '</span>';
          }

          /*==========  AWARD BY  ==========*/
          $awardContent['award_by'] = '<span class="award-by">' . get_the_title() . '</span>';

          /*==========  INSTITUTION  ==========*/
          if ( !empty($postData['institution'][0]) ) {
            $awardContent['institution'] = '<span class="award-intitution">' . $postData['institution'][0] . '</span>';
          }

          /*==========  PLACE  ==========*/
          $city    = !empty( $postData['city'][0] )    ? $postData['city'][0]    : NULL;
          $country = !empty( $postData['country'][0] ) ? $postData['country'][0] : NULL;

          if ( strcmp($city, $country) !== 0 ) {
            $awardContent['place'] = '<span class="award-place">' . $city . $contentSeparator . $country . '</span>';
          } else {
            $awardContent['place'] = '<span class="award-place">' . $country . '</p>';
          }


          $awardItem = '<tr class="jcg-cv-item award-item">';
            $awardItem .= '<td class="jcg-cv-item-col1 years">' . $date . '</td>';
            $awardItem .= '<td class="jcg-cv-item-col2 award-info">';

              $awardItem .= $awardType;
              if ( !empty($awardContent) ) {
                $awardItem .= implode($contentSeparator, $awardContent);
              }

            $awardItem .= '</td>'; // end .jcg-cv-item-col2
          $awardItem .= '</tr>'; // end .jcg-cv-item

          $about .= $awardItem;
        endwhile; wp_reset_postdata();
        $about .= '</tbody></table>';
      endif;

    $about .= '</div>'; // end #about-content

    echo $about;

    /*-----  End of ABOUT CONTENT  ------*/

    ?>

<?php get_footer(); ?>