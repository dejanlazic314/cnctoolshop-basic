document.addEventListener('DOMContentLoaded', () => {
  function initLightbox(container) {
    const body = document.body;
    const header = document.getElementById('header');
    const triggers = container.querySelectorAll('.lightbox-trigger');
    const modal = container.querySelector('.lightbox-modal');

    if (!modal || triggers.length === 0) return;

    const closeBtn = modal.querySelector('.lightbox-close');
    const image = modal.querySelector('.lightbox-image');

    const getScrollbarWidth = () => {
      return window.innerWidth - document.documentElement.clientWidth;
    };

    triggers.forEach((trigger) => {
      trigger.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();

        const src = trigger.dataset.src;
        if (src) {
          openLightbox(src);
        }
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

    function openLightbox(src) {
      image.src = src;
      modal.classList.add('active');
      const scrollbarWidth = getScrollbarWidth();
      body.style.paddingRight = `${scrollbarWidth}px`;
      header.style.paddingRight = `${scrollbarWidth}px`;
      document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
      modal.classList.remove('active');
      body.style.paddingRight = '';
      header.style.paddingRight = '';
      document.body.style.overflow = '';
      image.src = '';
    }
  }

  document.querySelectorAll('.ce_gridSection').forEach((element) => {
    initLightbox(element);
  });
});
