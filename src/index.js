import './style.scss';
import Gallery from './js/Gallery';

let galleries = document.querySelectorAll('.jcg-gallery');

if (galleries.length) {
  for (let i = 0; i < galleries.length; i++) {
    new Gallery(galleries[i]);
  }
}
