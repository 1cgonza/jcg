<?php
// Error pages such as 404 don't have post ID, so first check if the post exists before creating urls for social media cards.
if ( is_post_type_archive () ) {
  $linkbackUrl = get_post_type_archive_link( get_post_type ($post) );
} elseif ( isset($post) ) {
  $linkbackUrl = get_permalink( $post->ID );
} elseif ( is_404() ) {
  $linkbackUrl = site_url('/soyoufoundthiserrorpageanddecidedtoshareitsocialmediawelliappreciatethat');
} else {
  $linkbackUrl = site_url();
}

// Check for featured image and set the size for the version we want to use on social media sites.
if ( isset($post) && has_post_thumbnail() ) {
  $featuredImgId     = get_post_thumbnail_id();
  $featuredImgObject = wp_get_attachment_image_src($featuredImgId, 'jcg-1200x630');
  $featuredImg       = $featuredImgObject[0];
  $featuredImgWidth  = $featuredImgObject[1];
  $featuredImgHeight = $featuredImgObject[2];
} else {
  $featuredImg       = site_url('/wp-content/uploads/sites/5/2011/11/SiSiSiSiSiSiSiSiSiSiSi-1-1200x630.jpg');
  $featuredImgWidth  = '1200';
  $featuredImgHeight = '630';
}

if ( is_singular('films') ) { // Set post types first because otherwise single is always true and can't check for post-type
  $jcgDescription = get_field('synopsis', false, false);
  $ogType = 'video:movie';
  $cardType = 'player';
} elseif ( is_singular() ) {
  $jcgDescription = the_excerpt();
  $ogType = 'article';
  $cardType = 'summary_large_image';
} else {
  global $jcgDescription;
  $ogType = 'website';
  $cardType = 'summary_large_image';
}
?>
<!doctype html>
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
    <meta property="og:url" content="<?php echo $linkbackUrl; ?>" />
    <meta property="og:type" content="<?php echo $ogType; ?>" />
    <?php if ( is_singular('films') ) { ?>
    <meta property="video:release_date" content="<?php the_field('release_date');?>">
    <meta property="video:director" content="<?php echo get_page_link(20); // In this site the post with ID 20 is the about page. ?>">
    <?php } ?>
    <meta property="og:image" content="<?php echo $featuredImg;  ?>">
    <meta property="og:image:width" content="<?php echo $featuredImgWidth;  ?>">
    <meta property="og:image:height" content="<?php echo $featuredImgHeight;  ?>">
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
    <meta name="twitter:domain" content="<?php echo $linkbackUrl; ?>">
    <?php if ( is_singular('films') ) { ?>
    <meta name="twitter:player" content="<?php echo get_field('url', false, false); ?>">
    <meta name="twitter:player:height" content="500">
    <meta name="twitter:player:width" content="889">
    <?php } ?>
    <meta name="twitter:image:src" content="<?php echo $featuredImg;  ?>">

    <?php wp_head(); ?>
  </head>

  <body <?php body_class(); ?>>
    <header class="menu">
      <nav role="navigation">
        <?php wp_nav_menu(array(
          'container'       => false,
          'menu'            => 'The Main Menu',
          'menu_class'      => 'main-nav',
          'theme_location'  => 'main-nav',
          'before'          => '',
          'after'           => '',
          'link_before'     => '',
          'link_after'      => '',
          'depth'           => 0
        )); ?>
      </nav>
    </header> <?php // .menu ?>