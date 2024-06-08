var swiper = new Swiper(".hero-banner__swiper", {
  effect: "fade",
  speed: 500,
  autoplay: true,
});

var swiper = new Swiper(".product-single__main", {
  spaceBetween: 10,
  slidesPerView: 4,
  freeMode: true,
  watchSlidesProgress: true,
});

var swiper2 = new Swiper(".product-single__thumb", {
  spaceBetween: 10,
  effect: "fade",
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  thumbs: {
    swiper: swiper,
  },
});
