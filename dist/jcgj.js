!function(){"use strict";function e(e,t){for(var n=0;n<t.length;n++){var a=t[n];a.enumerable=a.enumerable||!1,a.configurable=!0,"value"in a&&(a.writable=!0),Object.defineProperty(e,a.key,a)}}var t=function(){function t(e){var n=this;!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,t),this._cachedImgs={},this.gall=e,this.thumbnails=e.querySelector(".thumbnails"),this.container=e.querySelector(".jcg-gallery-image-container");var a=this.thumbnails.children[0];this.current=a,a.classList.add("current");var i=window.innerHeight/this.thumbnails.children.length|0;this.thumbnails.style.width="".concat(i-6-5,"px");for(var r=function(e){var t=n.thumbnails.children[e];t.onclick=function(e){e.preventDefault(),n.current.classList.remove("current"),t.classList.add("current"),n.current=t,n.loadImage(t.dataset.large)}},l=0;l<this.thumbnails.children.length;l++)r(l);this.loadImage(a.dataset.large)}var n,a;return n=t,(a=[{key:"loadNewImg",value:function(e){var t=this,n=new Image;n.onload=function(){n.naturalWidth>t.container.clientWidth?(n.style.height="auto",n.style.width="98%"):(n.style.height="98%",n.style.width="auto"),t.appendGallImg(n),t._cachedImgs[e]=n},n.src=e,n.classList.add("absoulteCenter")}},{key:"loadImage",value:function(e){this._cachedImgs.hasOwnProperty(e)?this.appendGallImg(this._cachedImgs[e]):this.loadNewImg(e)}},{key:"appendGallImg",value:function(e){this.container.innerText="",this.container.appendChild(e)}}])&&e(n.prototype,a),Object.defineProperty(n,"prototype",{writable:!1}),t}(),n=document.querySelectorAll(".jcg-gallery");if(n.length)for(var a=0;a<n.length;a++)new t(n[a])}();