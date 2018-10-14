<?php
function jcg_comments($comment, $args, $depth) {
  $GLOBALS['comment'] = $comment;

  $commClasses     = comment_class('cf', $comment->comment_ID, $comment->comment_post_ID, false);
  $commDate        = new DateTime($comment->comment_date);

  $gravatarData    = md5( strtolower( trim( get_comment_author_email() ) ) );
  $gravatarDefault = get_template_directory_uri() . '/src/images/apple-icon-touch.png';
  $gravatarSize    = 80;
  $gravatarURL     = 'http://www.gravatar.com/avatar/' . $gravatarData . '?d=' . urlencode($gravatarDefault) . '&s=' . $gravatarSize;

  $HTML = '<div id="comment-' . $comment->comment_ID . '" ' . $commClasses . '>';
    $HTML .= '<article class="cf">';
      $HTML .= '<header class="comment-author vcard">';

        /*==========  GRAVATAR  ==========*/
        $HTML .= '<img class="avatar" src="' . $gravatarURL . '" alt="" />';

        /*==========  AUTHOR  ==========*/
        $HTML .= '<a class="comment-edit-link" href="' . get_edit_comment_link() . '" target="_self">(Edit) </a>';
        $HTML .= '<cite class="comment-author">' . get_comment_author_link() . ' </cite>';

        /*==========  TIMESTAMP  ==========*/
        $HTML .= '<time datetime="' . $commDate->format('Y-m-j') . '">' . $commDate->format('F jS, Y') . '</time>';
      $HTML .= '</header>';

      /*==========  WAITING MODERATION  ==========*/
      if ($comment->comment_approved == '0') {
        $HTML .= '<div class="alert alert-info">';
          $HTML .= '<p>Your comment is awaiting moderation.</p>';
        $HTML .= '</div>';
      }

      /*==========  COMMENT CONTENT  ==========*/
      $HTML .= '<section class="comment_content cf">';
        $HTML .= get_comment_text( $comment->comment_ID );
      $HTML .= '</section>';

      /*==========  REPLY BUTTON  ==========*/
      $replyArgs = array(
        'depth'     => $depth,
        'max_depth' => $args['max_depth']
      );
      $HTML .= get_comment_reply_link( array_merge($args, $replyArgs) );

    $HTML .= '</article>';

  // WP closes this div. (If you add the closing tag the HTML structure breaks)
  echo $HTML;
}
