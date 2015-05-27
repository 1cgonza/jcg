function loadGravatars() {
  // set the viewport using the function above
  viewport = updateViewportDimensions();
  // if the viewport is tablet or larger, we load in the gravatars
  if (viewport.width >= 768) {
    jQuery('.comment img[data-gravatar]').each(function(){
      jQuery(this).attr('src',jQuery(this).attr('data-gravatar'));
    });
  }
}

jQuery(document).ready(function($) {
  loadGravatars();

  /*===============================
  =            GALLERY            =
  ===============================*/
  var windowHeight = window.innerHeight;
  var containerW;

  function loadImage(path, height, target, containerW) {
    $('<img src="'+ path +'">').load(function() {
      //Make sure the container is empty so we only display one image at a time.
      $(this).parent().empty();
      $(this).height(height).css('opacity', '0').appendTo(target);

      var imgWidth = $(this).width();

      if (imgWidth < containerW) {
        $(this).fadeTo('slow', 1);
      } else {
        $(this).height('auto');
        $(this).width('100%');
        $(this).fadeTo('slow', 1);
      }

    });
  }

  /*==========  SETUP GALLERY  ==========*/
  $('.jcg-gallery').each(function(index) {
    var firstImg     = $(this).children('a').first();
    var gallerySize  = $(this).children('a').length;
    var galleryClass = '.jcg-gallery-' + index;
    var galleryID    = 'jcg-gallery-container-' + index;

    $(this).attr('id', galleryID);
    $(this).css('height', windowHeight);
    $(this).prepend('<div class="jcg-loading-image">loading</div>');
    $(this).prepend('<div class="' + 'jcg-gallery-' + index + ' jcg-gallery-image-container"></div>');

    containerW = $(galleryClass).width();

    firstImg.addClass('current');

    /*==========  SETUP THUMBNAILS  ==========*/
    $('.jcg-gallery a').each(function() {
      var thumbSize = windowHeight / gallerySize | 0;
      var borderW = 3;
      var gap = 5;
      $(this).width(thumbSize - (borderW * 2) - gap);
      // if ( !$(this).hasClass('current') ) {
      //   $(this).css('border', borderW + 'px solid');
      // }
    });

    loadImage(firstImg.attr('href'), windowHeight, galleryClass, containerW);

    /*==========  MOUSE EVENTS  ==========*/
    $(this).children('a').on('click', function(event) {
      event.preventDefault();
      $(this).parent().children('a').removeClass();
      $(this).addClass('current');
      $(galleryClass).empty();

      //check again just in case
      windowHeight = window.innerHeight;
      containerW = $(galleryClass).width();
      $(this).parent().css('height', windowHeight);

      var galleryId = $(this).parent().attr('id');

      $('html, body').animate({
        scrollTop: $('#' + galleryId).offset().top
      }, 200);

      var imgPath = $(this).attr('href');
      loadImage(imgPath, windowHeight, galleryClass, containerW);
    });
  });

  /*-----  End of GALLERY  ------*/

  $('.post-nav-item').hover( function() {
    $(this).removeClass('on');
    $(this).find('.post-nav-icon').fadeOut('fast');
    $(this).animate({ top: 0 }, 'fast');
  }, function() {
    var postNavItemH = $('.post-nav-item').height();

    $(this).find('.post-nav-icon').fadeIn('fast');
    $(this).animate({ top: postNavItemH - 22 }, 'slow');
  });

  $(window).load(function() {
    var postNavItemH = $('.post-nav-item').height();

    if ( $('#next-post-link').hasClass('on')) {
      $('#next-post-link').animate({
        top: postNavItemH - 22
      }, 'slow', function() {
        $(this).find('.post-nav-icon').fadeIn();
      });
    }

    if ( $('#previous-post-link').hasClass('on')) {
      $('#previous-post-link').animate({
        top: postNavItemH - 22
      }, 'slow', function() {
        $(this).find('.post-nav-icon').fadeIn();
      });
    }

  });
});
