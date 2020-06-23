/**
 * TODO:
 * - add preloader
 */
export default class Gallery {
  constructor(gall) {
    this._cachedImgs = {};
    this.gall = gall;
    this.thumbnails = gall.querySelector('.thumbnails');
    this.container = gall.querySelector('.jcg-gallery-image-container');
    const firstImg = this.thumbnails.children[0];
    this.current = firstImg;
    firstImg.classList.add('current');

    const thumbSize = (window.innerHeight / this.thumbnails.children.length) | 0;
    const borderW = 3;
    const gap = 5;
    this.thumbnails.style.width = `${thumbSize - borderW * 2 - gap}px`;

    for (let i = 0; i < this.thumbnails.children.length; i++) {
      const thumb = this.thumbnails.children[i];

      thumb.onclick = (e) => {
        e.preventDefault();
        this.current.classList.remove('current');
        thumb.classList.add('current');
        this.current = thumb;
        this.loadImage(thumb.dataset.large);
      };
    }

    this.loadImage(firstImg.dataset.large);
  }

  loadNewImg(path) {
    const img = new Image();
    img.onload = () => {
      if (img.naturalWidth > this.container.clientWidth) {
        img.style.height = 'auto';
        img.style.width = '98%';
      } else {
        img.style.height = '98%';
        img.style.width = 'auto';
      }

      this.appendGallImg(img);
      this._cachedImgs[path] = img;
    };
    img.src = path;
    img.classList.add('absoulteCenter');
  }

  loadImage(path) {
    if (this._cachedImgs.hasOwnProperty(path)) {
      this.appendGallImg(this._cachedImgs[path]);
    } else {
      this.loadNewImg(path);
    }
  }

  appendGallImg(img) {
    this.container.innerText = '';
    this.container.appendChild(img);
  }
}
