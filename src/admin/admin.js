(function ($) {
  'use strict';

  if ($('body').hasClass('media_page_jcg_flickr')) {
    $('.jcg-flickr-img').click(function (event) {
      event.preventDefault();
      var photoID = $(this).data('id');
      var apiKey = $('#jcg-flickr-gallery').data('apikey');
      requestImgData(photoID, apiKey);
    });
  }

  function requestImgData(id, key) {
    var $container = $('.jcg-flickr-data-container');
    var url =
      'https://api.flickr.com/services/rest/?api_key=' +
      key +
      '&method=flickr.photos.getSizes' +
      '&photo_id=' +
      id +
      '&format=json' +
      '&nojsoncallback=1';

    $container.html('requesting data...');

    $.getJSON(url, function (res) {
      $container.html('success!');
    })
      .done(function (data) {
        var sizes = data.sizes.size;
        var response = '<table>';

        $.each(sizes, function (index, value) {
          response =
            response +
            '<tr>' +
            '<td><a href="' +
            value.source +
            '" target="_blank">' +
            '<span class="dashicons dashicons-format-image"></span>' +
            '</td>' +
            '<td>' +
            value.width +
            ' x ' +
            value.height +
            '</td>' +
            '<td>' +
            value.source +
            '</td>' +
            '</tr>';
        });

        response = response + '</table>';

        $container.html(response);
      })
      .fail(function (err) {
        console.log(err);
      });
  }
})(jQuery);
