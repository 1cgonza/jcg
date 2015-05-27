(function($) {
  function renderMediaUploader() {
    // 'use strict';

    var file_frame, image_data;

    /**
     * If an instance of file_frame already exists, then we can open it
     * rather than creating a new instance.
     */
    if ( undefined !== file_frame ) {
      file_frame.open();
      return;
    }

    file_frame = wp.media.frames.file_frame = wp.media({
      title: 'Profile Picture',
      button: {
        text: 'Update',
        close: true
      },
      frame:    'post',
      state:    'insert',
      multiple: false
    });

    /**
     * Setup an event handler for what to do when an image has been selected.
     * Since we're using the 'view' state when initializing the file_frame,
     * we need to make sure that the handler is attached to the insert event.
     */
    file_frame.on( 'insert', function () {
      var data       = file_frame.state().get('selection').first().toJSON();
      var $container = $('#profile-image-container');

      if ( data.url.length <= 0  ) {
        return;
      }

      var imgURL = data.url;
      if ( data.sizes.hasOwnProperty('jcg-1200x630') ) {
        imgURL = data.sizes['jcg-1200x630'].url;
      }

      $('#profile-image-input').val(imgURL);

      assignProfileImage(imgURL, data.caption, data.title);


    // Next, hide the anchor responsible for allowing the user to select an image
    $container
        .prev()
        .hide();
    });

    // Now display the actual file_frame
    file_frame.open();

  }

  function assignProfileImage (url, caption, title) {
    var $image = $('#profile-image');
    var $input = $('#profile-image-input');

    $image.attr('src', url);
    $image.attr('alt', caption);
    $image.attr('title', title);
    $image.show();
    $image.parent().removeClass('hidden');
  }

  $(function () {
    if ($('#profile-image-input').val().length > 0) {
      var profileImageUrl = $('#profile-image-input').val();
      var profileImageCaption = $('#profile-image').attr('alt');
      var profileImageTitle = $('#profile-image').attr('title');
      assignProfileImage(profileImageUrl, profileImageCaption, profileImageTitle);
    }

    $('#assign-profile-image').on( 'click', function (event) {
      event.preventDefault();

      renderMediaUploader();

    });
  });
})(jQuery);