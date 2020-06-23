<?php
/*
	Template Name: About
*/
get_header();
	$aboutData = (array)get_option('jcg_about_options');
	$authorName = get_bloginfo('name');
	$bio        = !empty($aboutData['bio'])  ? apply_filters( 'the_content', $aboutData['bio'] ) : '';

	$cvSections = array(
		'education',
		'awards',
		'experience-in-education',
		'experience-in-cultural-initiatives',
		'public-lectures-conferences',
		'exhibitions',
		'experience-in-animation-industry'
	);

	/*========================================
	=            HEADER - PROFILE            =
	========================================*/
	$profile = '<div id=profile class="cf">';

    $profile .= '<div id="about-info">';
		$profile .= '<h1>' . $authorName . '</h1>';
		$profile .= jcg_contact_info();

    $profile .= '</div>'; //end #about-info
  $profile .= '</div>'; // end #profile

	echo $profile;

	/*-----  End of HEADER - PROFILE  ------*/

	$about = '<div id="about-content">';
    $about .= '<div id="bio">' . $bio . '</div>';
    foreach ($cvSections as $section) {
      $cvSection = new CV_Builder($section);
      $about .= $cvSection->render();
    }
  	$about .= '</div>'; // end #about-content

	echo $about;

get_footer();
