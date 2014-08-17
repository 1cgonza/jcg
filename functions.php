<?php
  require_once( 'library/jcg.php' );
  require_once( 'library/custom-post-type.php' );
  require_once( 'library/admin.php' );

  function jcg_init() {
    add_filter( 'wp_title', 'rw_title', 10, 3 );
    add_filter( 'the_generator', 'jcg_rss_version' );
    add_filter( 'wp_head', 'jcg_remove_wp_widget_recent_comments_style', 1 );
    add_action( 'wp_head', 'jcg_remove_recent_comments_style', 1 );
    add_filter( 'gallery_style', 'jcg_gallery_style' );
    add_action( 'wp_enqueue_scripts', 'jcg_scripts_and_styles', 999 );

    jcg_theme_support();

    add_filter( 'the_content', 'jcg_filter_ptags_on_images' );
    add_filter( 'excerpt_more', 'jcg_excerpt_more' );
  }
  add_action( 'after_setup_theme', 'jcg_init' );

  /*------------------------------------

          THUMBNAIL SIZE OPTIONS

  --------------------------------------*/

  add_image_size( 'jcg-1300x325', 1300, 325, true );
  add_image_size( 'jcg-1200x630', 1200, 630, true );
  add_image_size( 'jcg-300x100', 300, 100, true );

  function jcg_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
      'jcg-1300x325' => '1300px by 325px',
      'jcg-1200x630' => '1200px by 630px',
      'jcg-300x100'  => '300px by 100px',
    ) );
  }
  add_filter( 'image_size_names_choose', 'jcg_custom_image_sizes' );

  // Change default size in galleries to 300x300
  function jcg_gallery( $out, $pairs, $atts ) {
    $atts = shortcode_atts( array(
      'columns' => '2',
      'size' => 'medium',
    ), $atts );

    $out['columns'] = $atts['columns'];
    $out['size'] = $atts['size'];

    return $out;
  }
  add_filter( 'shortcode_atts_gallery', 'jcg_gallery', 10, 3 );

  /*------------------------------------

              COMMENT LAYOUT

  --------------------------------------*/

  function jcg_comments( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment; ?>
    <div id="comment-<?php comment_ID(); ?>" <?php comment_class('cf'); ?>>
      <article  class="cf">
        <header class="comment-author vcard">
          <?php $bgauthemail = get_comment_author_email(); ?>
          <img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=40" class="load-gravatar avatar avatar-48 photo" height="40" width="40" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />

          <?php printf( '<cite class="fn">%1$s</cite> %2$s', get_comment_author_link(), edit_comment_link( '(Edit)','  ','') ) ?>
          <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time( 'F jS, Y' ); ?> </a></time>

        </header>
        <?php if ($comment->comment_approved == '0') : ?>
          <div class="alert alert-info">
            <p><?php echo 'Your comment is awaiting moderation.'; ?></p>
          </div>
        <?php endif; ?>
        <section class="comment_content cf">
          <?php comment_text() ?>
        </section>
        <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
      </article>
  <?php
  }

  /*------------------------------------

               GOOGLE FONTS

  --------------------------------------*/

  function jcg_fonts() {
    wp_register_style('googleFonts', 'http://fonts.googleapis.com/css?family=Raleway:300,600');
    wp_enqueue_style( 'googleFonts');
  }
  add_action('wp_print_styles', 'jcg_fonts');
?>
