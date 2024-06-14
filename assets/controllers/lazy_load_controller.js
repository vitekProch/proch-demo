// assets/controllers/lazy_load_controller.js
import { Controller } from 'stimulus';

export default class extends Controller {
    connect() {
        if (this.element.querySelector('img')) {
            this.loadImage();
        }
    }

    loadImage() {
        const img = this.element.querySelector('img');
        img.onload = () => {
            this.element.querySelector('.loader').style.display = 'none';
            img.style.opacity = 1;
        };
        img.src = img.dataset.src;
    }
}
