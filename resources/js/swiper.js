import Swiper from "swiper";
import 'swiper/css';
import { Navigation, Pagination } from 'swiper/modules';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.swiper').forEach((el) => {
        const slideCount = el.querySelectorAll('.swiper-slide').length;
        new Swiper(el, {
            modules: [Navigation, Pagination],     
            loop: slideCount > 1,
            pagination: {
                el: el.querySelector('.swiper-pagination'),
                clickable: true,
            },
            navigation: {
                nextEl: el.querySelector('.swiper-button-next'),
                prevEl: el.querySelector('.swiper-button-prev'),
            },
        });
    });
});