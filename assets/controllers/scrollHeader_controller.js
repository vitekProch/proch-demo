import { Controller } from 'stimulus';

export default class extends Controller {
    static targets = ['navbar', 'hamburger'];

    connect() {
        window.addEventListener('scroll', this.handleScroll);
        this.element.classList.remove('bg-body-tertiary');
    }

    disconnect() {
        window.removeEventListener('scroll', this.handleScroll);
    }

    handleScroll = () => {
        if (!this.navbarTarget.classList.contains('show')) {
            if (window.scrollY > 0) {
                this.element.classList.add('bg-body-tertiary');
            } else {
                this.element.classList.remove('bg-body-tertiary');
            }
        }
    };

    toggleBackground() {
        const menuOpen = JSON.parse(this.hamburgerTarget.getAttribute('aria-expanded'));

        if (this.navbarTarget.classList.contains('show')) {
            this.element.classList.remove('bg-body-tertiary');
        } else {
            if (window.scrollY === 0) {
                this.element.classList.add('bg-body-tertiary');
            }
        }
        if (window.scrollY === 0 && !menuOpen) {
            console.log(this.hamburgerTarget.getAttribute('aria-expanded'))
            this.element.classList.remove("bg-body-tertiary")
        }
    }
}
