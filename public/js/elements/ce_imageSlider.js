document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.ce_imageSlider .splide').forEach((element) => {
    new Splide(element, {
      type: 'loop',
      keyboard: true,
      arrows: true,
      pagination: true,
      perPage: 1,
      gap: '2rem',
    }).mount();
  });
});
