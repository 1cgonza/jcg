<?php
/*
 Template Name: About
*/
get_header();

    $aboutData = (array)get_option('jcg_about_options');
    $contentSeparator = ', ';
    $dateformatstring = 'Y';

    $profilePic = get_the_post_thumbnail($post->ID, 'large');
    $authorName = get_bloginfo('name');
    $bio         = !empty($aboutData['bio'])  ? apply_filters( 'the_content', $aboutData['bio'] ) : '';
    $education   = new JCGCV('education', $contentSeparator, $dateformatstring);
    $awards      = new JCGCV('awards', $contentSeparator, $dateformatstring);
    $lectures    = new JCGCV('public-lectures-conferences', $contentSeparator, $dateformatstring);
    $cultural    = new JCGCV('experience-in-cultural-initiatives', $contentSeparator, $dateformatstring);
    $exEducation = new JCGCV('experience-in-education', $contentSeparator, $dateformatstring);
    $exhibition  = new JCGCV('exhibitions', $contentSeparator, $dateformatstring);

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

    $about = '<div id="about-content">';
      $about .= '<div id="bio">' . $bio . '</div>';
      $about .= $education->content;
      $about .= $awards->content;
      $about .= $exEducation->content;
      $about .= $lectures->content;
      $about .= $cultural->content;
      $about .= $exhibition->content;
    $about .= '</div>'; // end #about-content

    echo $about;

get_footer(); ?>