(function () {
    'use strict';

    let swiper = new Swiper(".swiper-view-details", {
        spaceBetween: 10,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesProgress: true,
    });
    let swiper2 = new Swiper(".swiper-preview-details", {
        spaceBetween: 10,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        thumbs: {
            swiper: swiper,
        }
    });

})();