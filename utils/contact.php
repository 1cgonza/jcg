<?php
function jcg_contact_info() {
  $externalLinks = [];
  $aboutData     = (array)get_option('jcg_about_options');
  $primaryEmail  = !empty( $aboutData['email'] ) ? antispambot($aboutData['email']) : NULL;
  $phone         = !empty( $aboutData['phone'] ) ? $aboutData['phone'] : NULL;
  /*==========  SOCIAL LINKS  ==========*/
  $github   = !empty( $aboutData['github'] )    ? $externalLinks['GitHub']   = $aboutData['github']   : NULL;
  $vimeo    = !empty( $aboutData['vimeo'] )     ? $externalLinks['Vimeo']    = $aboutData['vimeo']    : NULL;
  $youtube  = !empty( $aboutData['youtube'] )   ? $externalLinks['YouTube']  = $aboutData['youtube']  : NULL;
  $facebook = !empty( $aboutData['facebook'] )  ? $externalLinks['Facebook'] = $aboutData['facebook'] : NULL;
  $twitter  = !empty( $aboutData['twitter'] )   ? $externalLinks['Twitter']  = $aboutData['twitter']  : NULL;
  $flickr   = !empty( $aboutData['flickr'] )    ? $externalLinks['Flickr']   = $aboutData['flickr']   : NULL;
  $linkedin = !empty( $aboutData['linkedin'] )  ? $externalLinks['LinkedIn'] = $aboutData['linkedin'] : NULL;
  $imdb     = !empty( $aboutData['imdb'] )      ? $externalLinks['IMDB']     = $aboutData['imdb']     : NULL;

  $contact = '<div class="jcg-contact-info">';
    $contact .= $primaryEmail ? '<span class="contact-item primary-email">' . $primaryEmail . '</span>' : '';
    $contact .= $phone ? '<span class="contact-item phone-number">' . $phone . '</span>' : '';
      $contact .= '<ul id="social-links">';
      foreach ($externalLinks as $vendor => $url) {
        $contact .= '<li><a class="' . strtolower($vendor) . ' social-icon" href="' . $url . '" target="_blank">' . $vendor . '</a></li>';
      }
    $contact .= '</ul>';
  $contact .= '</div>';

  return $contact;
}
