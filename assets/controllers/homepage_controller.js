import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect(){
        this.reviewSlider();
        this.portfolioSlider();
    }
    
    reviewSlider(){
        const reviewSlider = new Swiper('.review-slider', {
            lazy: true,
            direction: 'horizontal',
            slidesPerView: 1,
            loop: true,
            // If we need pagination
            pagination: {
              el: '.swiper-pagination',
            },
          
            // Navigation arrows
            navigation: {
              nextEl: '.swiper-button-next',
              prevEl: '.swiper-button-prev',
            },
          
        });
    }
    
    portfolioSlider(){
        const portfolioSlider = new Swiper('.categories-slider', {
            lazy: true,
            direction: 'horizontal',
            slidesPerView: 1,
            spaceBetween: 10,
            // If we need pagination
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        
            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                400: {
                    slidesPerView: 1,
                    spaceBetween: 0,
                },
                640: {
                    slidesPerView: 2,
                    spaceBetween: 0,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 0,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 0,
                },
            }
        
        });
    }
}
