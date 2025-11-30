document.addEventListener('DOMContentLoaded', () => {
  function initGallery(element) {
    const items = element.querySelectorAll('.gallery-item');
    const modal = element.querySelector('.lightbox-modal');
    const closeBtn = modal.querySelector('.lightbox-close');
    const splideElement = modal.querySelector('.splide');

    let splide = null;

    items.forEach((item, index) => {
      item.addEventListener('click', () => {
        openLightbox(index);
      });
    });

    closeBtn.addEventListener('click', closeLightbox);

    modal.addEventListener('click', (e) => {
      if (e.target === modal) closeLightbox();
    });

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && modal.classList.contains('active')) {
        closeLightbox();
      }
    });

    function openLightbox(startIndex) {
      modal.classList.add('active');
      document.body.style.overflow = 'hidden';

      if (!splide) {
        splide = new Splide(splideElement, {
          type: 'loop',
          start: startIndex,
          keyboard: true,
          arrows: true,
          pagination: true,
        });

        splide.mount();
      } else {
        splide.go(startIndex);
      }
    }

    function closeLightbox() {
      modal.classList.remove('active');
      document.body.style.overflow = '';
    }
  }

  document.querySelectorAll('.ce_imageShowcase').forEach((element) => {
    initGallery(element);
  });
});
