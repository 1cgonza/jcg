/*
 * IE8 ployfill for GetComputed Style (for Responsive Script below)
 * If you don't want to support IE8, you can just remove this.
*/
if (!window.getComputedStyle) {
  window.getComputedStyle = function(el, pseudo) {
    this.el = el;
    this.getPropertyValue = function(prop) {
      var re = /(\-([a-z]){1})/g;
      if (prop == 'float') prop = 'styleFloat';
      if (re.test(prop)) {
        prop = prop.replace(re, function () {
          return arguments[2].toUpperCase();
        });
      }
      return el.currentStyle[prop] ? el.currentStyle[prop] : null;
    };
    return this;
  };
}

/*
 * Get Viewport Dimensions
 * returns object with viewport dimensions to match css in width and height properties
 * ( source: http://andylangton.co.uk/blog/development/get-viewport-size-width-and-height-javascript )
*/
function updateViewportDimensions() {
	var w=window,d=document,e=d.documentElement,g=d.getElementsByTagName('body')[0],x=w.innerWidth||e.clientWidth||g.clientWidth,y=w.innerHeight||e.clientHeight||g.clientHeight;
	return {width:x,height:y};
}
// setting the viewport width
var viewport = updateViewportDimensions();

/*
 * Throttle Resize-triggered Events
 * Wrap your actions in this function to throttle the frequency of firing them off, for better performance, esp. on mobile.
 * ( source: http://stackoverflow.com/questions/2854407/javascript-jquery-window-resize-how-to-fire-after-the-resize-is-completed )
*/
var waitForFinalEvent = (function () {
	var timers = {};
	return function (callback, ms, uniqueId) {
		if (!uniqueId) { uniqueId = "Don't call this twice without a uniqueId"; }
		if (timers[uniqueId]) { clearTimeout (timers[uniqueId]); }
		timers[uniqueId] = setTimeout(callback, ms);
	};
})();

// how long to wait before deciding the resize has stopped, in ms. Around 50-100 should work ok.
var timeToWaitForLast = 100;


/*
 * Here's an example so you can see how we're using the above function
 *
 * This is commented out so it won't work, but you can copy it and
 * remove the comments.
 *
 *
 *
 * If we want to only do it on a certain page, we can setup checks so we do it
 * as efficient as possible.
 *
 * if( typeof is_home === "undefined" ) var is_home = $('body').hasClass('home');
 *
 * This once checks to see if you're on the home page based on the body class
 * We can then use that check to perform actions on the home page only
 *
 * When the window is resized, we perform this function
 * $(window).resize(function () {
 *
 *    // if we're on the home page, we wait the set amount (in function above) then fire the function
 *    if( is_home ) { waitForFinalEvent( function() {
 *
 *      // if we're above or equal to 768 fire this off
 *      if( viewport.width >= 768 ) {
 *        console.log('On home page and window sized to 768 width or more.');
 *      } else {
 *        // otherwise, let's do this instead
 *        console.log('Not on home page, or window sized to less than 768.');
 *      }
 *
 *    }, timeToWaitForLast, "your-function-identifier-string"); }
 * });
 *
 * Pretty cool huh? You can create functions like this to conditionally load
 * content and other stuff dependent on the viewport.
 * Remember that mobile devices and javascript aren't the best of friends.
 * Keep it light and always make sure the larger viewports are doing the heavy lifting.
 *
*/

/*
 * We're going to swap out the gravatars.
 * In the functions.php file, you can see we're not loading the gravatar
 * images on mobile to save bandwidth. Once we hit an acceptable viewport
 * then we can swap out those images since they are located in a data attribute.
*/
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
