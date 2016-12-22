<?php
$metaData = jcg_get_page_metadata();
?>
<!doctype html>
  <html <?php language_attributes(); ?>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="<?php echo $metaData['description']; ?>">
    <link rel="author" href="https://plus.google.com/+JuanCamiloGonz%C3%A1lezJ/posts">

    <?php /*==========  OPEN GRAPH  ==========*/ ?>
    <meta property="og:title" content="<?php the_title(); ?>" />
    <meta property="og:site_name" content="<?php bloginfo('name'); ?>">
    <meta property="og:description" content="<?php echo $metaData['description']; ?>">
    <meta property="og:url" content="<?php echo $metaData['url']; ?>" />
    <meta property="og:type" content="<?php echo $metaData['ogType']; ?>" />
    <?php if ( is_singular('films') ) { ?>
    <meta property="video:release_date" content="<?php echo get_post_meta($post->ID, 'release_date', true);?>">
    <meta property="video:director" content="<?php echo get_page_link(20); // In this site the post with ID 20 is the about page. ?>">
    <?php } ?>
    <meta property="og:image" content="<?php echo $metaData['featuredImg']; ?>">
    <?php /*==========  TWITTER CARD  ==========*/ ?>
    <meta name="twitter:card" content="<?php echo $metaData['cardType']; ?>">
    <meta name="twitter:site" content="@1cgonza">
    <meta name="twitter:creator" content="@1cgonza">
    <meta name="twitter:title" content="<?php the_title(); ?>">
    <meta name="twitter:description" content="<?php echo $metaData['description']; ?>">
    <meta name="twitter:domain" content="<?php global $post; echo $metaData['url']; ?>">
    <?php if ( is_singular('films') ) { ?>
    <meta name="twitter:player" content="<?php echo get_post_meta($post->ID, 'url', true); ?>">
    <meta name="twitter:player:height" content="500">
    <meta name="twitter:player:width" content="889">
    <?php } ?>
    <meta name="twitter:image:src" content="<?php echo $metaData['featuredImg'];  ?>">

    <?php wp_head(); ?>
  </head>

  <body <?php body_class(); ?>>
    <aside id="main-sidebar" class="m-all t-1of5 d-1of7 ld-1of7">

      <?php $logo = get_theme_mod('site_logo', false);
      if ( !empty($logo) ) : ?>
      <h1 id="logo"><a href="<?php echo home_url(); ?>" rel="nofollow"><?php echo get_theme_mod('site_logo'); ?></a></h1>
      <?php endif; ?>

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

      <section class="contact-aside">
        <h3 class="contact-title">Contact</h3>
        <?php echo jcg_contact_info(); ?>
      </section>

      <?php echo do_shortcode( '[jetpack_subscription_form title="" subscribe_text=""]' ); ?>
    </aside>

    <main id="content" class="m-all t-4of5 d-6of7 ld-6of7 last-col">