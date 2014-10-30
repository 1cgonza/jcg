<?php
if ( has_post_thumbnail() ) {
  $featuredImgId = get_post_thumbnail_id();
  $featuredImg = wp_get_attachment_image_src( $featuredImgId, 'jcg-1200x630' );
  // var_dump($featredImg);
}
// TEMPORARY
$fallbackImage = site_url('/wp-content/uploads/sites/5/2011/11/SiSiSiSiSiSiSiSiSiSiSi-1-1200x630.jpg');


if ( is_singular('films') ) { // Set post types first because otherwise single is always true and can't check for post-type
  $jcgDescription = get_field('synopsis', false, false);
  $ogType = 'video:movie';
  $cardType = 'player';
} elseif ( is_singular() ) {
  $jcgDescription = get_the_excerpt();
  $ogType = 'article';
  $cardType = 'summary_large_image';
} else {
  global $jcgDescription;
  $ogType = 'website';
  $cardType = 'summary_large_image';
}
?>
<!doctype html>
  <html <?php language_attributes(); ?>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php wp_title('|'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="<?php echo $jcgDescription; ?>">
    <link rel="author" href="https://plus.google.com/+JuanCamiloGonz%C3%A1lezJ/posts">
    <?php
      /*------------------------------------------

                          FAVICON

      --------------------------------------------*/
    ?>
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-touch.png">
    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png">
    <?php
      /*------------------------------------------

                        OPEN GRAPH

      --------------------------------------------*/
    ?>
    <meta property="og:title" content="<?php the_title(); ?>" />
    <meta property="og:site_name" content="<?php bloginfo('name'); ?>">
    <meta property="og:description" content="<?php echo $jcgDescription; ?>">
    <meta property="og:url" content="<?php echo get_permalink( $post->ID ); ?>" />
    <meta property="og:type" content="<?php echo $ogType; ?>" />
    <?php if ( is_singular('films') ) { ?>
    <meta property="video:release_date" content="<?php the_field('release_date');?>">
    <meta property="video:director" content="<?php echo get_page_link(20); // In this site the post with ID 20 is the about page. ?>">
    <?php } ?>
    <?php if ( has_post_thumbnail() ) { ?>
    <meta property="og:image" content="<?php echo $featuredImg[0];  ?>">
    <meta property="og:image:width" content="<?php echo $featuredImg[1];  ?>">
    <meta property="og:image:height" content="<?php echo $featuredImg[2];  ?>">
    <?php } else { ?>
    <meta property="og:image" content="<?php echo $fallbackImage; ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <?php } ?>
    <?php
      /*------------------------------------------

                        TWITTER CARD

      --------------------------------------------*/
    ?>
    <meta name="twitter:card" content="<?php echo $cardType; ?>">
    <meta name="twitter:site" content="@1cgonza">
    <meta name="twitter:creator" content="@1cgonza">
    <meta name="twitter:title" content="<?php the_title(); ?>">
    <meta name="twitter:description" content="<?php echo $jcgDescription; ?>">
    <meta name="twitter:domain" content="<?php echo get_permalink( $post->ID ); ?>">
    <?php if ( is_singular('films') ) { ?>
    <meta name="twitter:player" content="<?php echo get_field('url', false, false); ?>">
    <meta name="twitter:player:height" content="500">
    <meta name="twitter:player:width" content="889">
    <?php } ?>
    <?php if ( has_post_thumbnail() ) { ?>
    <meta name="twitter:image:src" content="<?php echo $featuredImg[0];  ?>">
    <?php } else { ?>
    <meta name="twitter:image:src" content="<?php echo $fallbackImage;  ?>">
    <?php } ?>

    <?php wp_head(); ?>
  </head>

  <body <?php body_class(); ?>>
    <div id="container">
      <div id="main-sidebar" class="m-all t-1of5 d-1of10">
        <div id="logo">
          <a href="<?php echo home_url(); ?>" rel="nofollow">
            <img src="<?php echo get_template_directory_uri(); ?>/library/images/sisisi-mandala.gif" alt="" />
          </a>
        </div>

        <nav role="navigation">
          <?php wp_nav_menu(array(
            'container'       => false,
            'container_class' => 'cf',
            'menu'            => 'The Main Menu',
            'menu_class'      => 'nav top-nav cf',
            'theme_location'  => 'main-nav',
            'before'          => '',
            'after'           => '',
            'link_before'     => '',
            'link_after'      => '',
            'depth'           => 0,
            'fallback_cb'     => ''
          )); ?>
        </nav>
      </div>