!function(e){function t(t,i,a){var r=e("#profile-image");e("#profile-image-input"),r.attr("src",t),r.attr("alt",i),r.attr("title",a),r.show(),r.parent().removeClass("hidden")}e((function(){e("#profile-image-input").val().length>0&&t(e("#profile-image-input").val(),e("#profile-image").attr("alt"),e("#profile-image").attr("title")),e("#assign-profile-image").on("click",(function(i){var a;i.preventDefault(),void 0===a?((a=wp.media.frames.file_frame=wp.media({title:"Profile Picture",button:{text:"Update",close:!0},frame:"post",state:"insert",multiple:!1})).on("insert",(function(){var i=a.state().get("selection").first().toJSON(),r=e("#jcg-profile-image-container");if(!(i.url.length<=0)){var l=i.url;i.sizes.hasOwnProperty("jcg-1200x630")&&(l=i.sizes["jcg-1200x630"].url),e("#profile-image-input").val(l),t(l,i.caption,i.title),r.prev().hide()}})),a.open()):a.open()}))}))}(jQuery);