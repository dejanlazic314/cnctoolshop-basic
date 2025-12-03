document.addEventListener('DOMContentLoaded', function () {
  const logoWallElements = document.querySelectorAll('.ce_logoClients .splide');

  if (logoWallElements.length === 0) return;

  const splideDefaultOptions = {
    type: 'loop',
    autoWidth: true,
    height: '50px',
    arrows: false,
    pagination: false,
    gap: '60px',
    drag: 'free',
    focus: 'center',
    perMove: 1,
    autoScroll: {
      speed: 0.5,
      pauseOnHover: true,
      pauseOnFocus: false,
      autoStart: true,
    },
    breakpoints: {
      720: {
        height: '40px',
      },
      580: {
        height: '35px',
      },
    },
  };

  logoWallElements.forEach((logoWallElement) => {
    const splide = new Splide(logoWallElement, splideDefaultOptions);
    splide.mount(window.splide.Extensions);
  });
});
