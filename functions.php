<?php
  require_once('library/jcg.php');
  require_once('library/custom-post-type.php');
  require_once('library/admin.php');

  add_action('after_setup_theme', 'jcg_init');

  function jcg_init() {
    add_action('init', 'disable_emojis');
    add_filter('the_generator', 'jcg_rss_version');
    add_filter('wp_head', 'jcg_remove_wp_widget_recent_comments_style', 1);
    add_action('wp_head', 'jcg_remove_recent_comments_style', 1);
    add_filter('gallery_style', 'jcg_gallery_style');
    add_action('wp_enqueue_scripts', 'jcg_scripts_and_styles', 999);

    jcg_theme_support();

    add_action('widgets_init', 'jcg_register_sidebars');
    add_filter('the_content', 'jcg_filter_ptags_on_images');
    add_filter('excerpt_more', 'jcg_excerpt_more');
  }

  /**
  * Set oEmbed width
  **/
  if ( !isset($content_width) ) {
  	$content_width = 640;
  }

  /*==========  THUMBNAILS  ==========*/
  add_image_size('jcg-1300x325', 1300, 325, true);
  add_image_size('jcg-1200x630', 1200, 630, true);
  add_image_size('jcg-900x100', 900, 100, true);
  add_image_size('jcg-300', 300, 100, true);

  function jcg_custom_image_sizes($sizes) {
    return array_merge($sizes, array(
      'jcg-1300x325' => '1300px by 325px',
      'jcg-1200x630' => '1200px by 630px',
      'jcg-post-nav' => '900px by 100px',
      'jcg-300x100'  => '300px by 100px'
    ));
  }
  add_filter('image_size_names_choose', 'jcg_custom_image_sizes');

  // Change default size in galleries to 300x300
  function jcg_gallery( $out, $pairs, $atts ) {
    $atts = shortcode_atts( array(
      'columns' => '2',
      'size' => 'medium',
    ), $atts );

    $out['columns'] = $atts['columns'];
    $out['size']    = $atts['size'];

    return $out;
  }
  add_filter( 'shortcode_atts_gallery', 'jcg_gallery', 10, 3 );

  /*==========  SIDEBARS  ==========*/
  function jcg_register_sidebars() {
  	register_sidebar(array(
      'id'            => 'sidebar1',
      'name'          => 'Sidebar 1',
      'description'   => 'The first (primary) sidebar.',
      'before_widget' => '<div id="%1$s" class="widget %2$s">',
      'after_widget'  => '</div>',
      'before_title'  => '<h4 class="widgettitle">',
      'after_title'   => '</h4>',
  	));
  }

  /*==========  COMMENTS LAYOUT  ==========*/
  function jcg_comments($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;

    $commClasses     = comment_class('cf', $comment->comment_ID, $comment->comment_post_ID, false);
    $commDate        = new DateTime($comment->comment_date);

    $gravatarData    = md5( strtolower( trim( get_comment_author_email() ) ) );
    $gravatarDefault = get_template_directory_uri() . '/library/images/nothing.gif';
    $gravatarSize    = 80;
    $gravatarURL     = 'http://www.gravatar.com/avatar/' . $gravatarData . '?d=' . urlencode($gravatarDefault) . '&s=' . $gravatarSize;

    $ossComment = '<div id="comment-' . $comment->comment_ID . '" ' . $commClasses . '>';

      $ossComment .= '<article class="cf">';

        $ossComment .= '<header class="comment-author vcard">';

          /*==========  GRAVATAR  ==========*/
          $ossComment .= '<img class="avatar" src="' . $gravatarURL . '" alt="" />';

          /*==========  AUTHOR  ==========*/
          $ossComment .= '<a class="comment-edit-link" href="' . get_edit_comment_link() . '" target="_self">(Edit) </a>';
          $ossComment .= '<cite class="comment-author">' . get_comment_author_link() . ' </cite>';

          /*==========  TIMESTAMP  ==========*/
          $ossComment .= '<time datetime="' . $commDate->format('Y-m-j') . '">' . $commDate->format('F jS, Y') . '</time>';

        $ossComment .= '</header>';

        /*==========  WAITING MODERATION  ==========*/
        if ($comment->comment_approved == '0') {
          $ossComment .= '<div class="alert alert-info">';
            $ossComment .= '<p>Your comment is awaiting moderation.</p>';
          $ossComment .= '</div>';
        }

        /*==========  COMMENT CONTENT  ==========*/
        $ossComment .= '<section class="comment_content cf">';
          $ossComment .= get_comment_text( $comment->comment_ID );
        $ossComment .= '</section>';

        /*==========  REPLY BUTTON  ==========*/
        $replyArgs = array(
          'depth'     => $depth,
          'max_depth' => $args['max_depth']
        );
        $ossComment .= get_comment_reply_link( array_merge($args, $replyArgs) );

      $ossComment .= '</article>';

    // WP closes this div. (If you add the closing tag the HTML structure breaks)
    echo $ossComment;
  }

  /*==========  JETPACK  ==========*/
  // Remove Open Graph from header
  add_filter( 'jetpack_enable_open_graph', '__return_false' );

  add_action('loop_start', 'jptweak_remove_share');
  function jptweak_remove_share() {
    remove_filter('the_excerpt', 'sharing_display',19);
    if ( class_exists('Jetpack_Likes') ) {
      remove_filter('the_content', array( Jetpack_Likes::init(), 'post_likes' ), 30, 1);
    }
  }