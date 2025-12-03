document.addEventListener('DOMContentLoaded', () => {
  const header = document.getElementById('header');
  const mobileToggle = document.getElementById('mobile-toggle');
  const mainNav = document.getElementById('main-nav');
  const body = document.body;

  let isMenuOpen = false;
  let isMobile = window.innerWidth <= 1023.98;
  let resizeTimer;

  const getScrollbarWidth = () => {
    return window.innerWidth - document.documentElement.clientWidth;
  };

  const toggleMobileMenu = () => {
    isMenuOpen = !isMenuOpen;

    if (isMenuOpen) {
      const scrollbarWidth = getScrollbarWidth();
      body.style.paddingRight = `${scrollbarWidth}px`;
      header.style.paddingRight = `${scrollbarWidth}px`;
    } else {
      body.style.paddingRight = '';
      header.style.paddingRight = '';
    }

    mobileToggle.classList.toggle('is-active', isMenuOpen);
    mobileToggle.setAttribute('aria-expanded', isMenuOpen);
    mobileToggle.setAttribute(
      'aria-label',
      isMenuOpen
        ? mobileToggle.dataset.labelClose
        : mobileToggle.dataset.labelOpen
    );

    mainNav.classList.toggle('is-open', isMenuOpen);
    body.classList.toggle('menu-open', isMenuOpen);
  };

  const closeMobileMenu = () => {
    if (!isMenuOpen) return;

    isMenuOpen = false;

    body.style.paddingRight = '';
    header.style.paddingRight = '';

    mobileToggle.classList.remove('is-active');
    mobileToggle.setAttribute('aria-expanded', 'false');
    mobileToggle.setAttribute('aria-label', 'Otvori meni');
    mainNav.classList.remove('is-open');
    body.classList.remove('menu-open');

    document
      .querySelectorAll('.header-nav-item.has-dropdown.is-open')
      .forEach((item) => {
        item.classList.remove('is-open');
      });
  };

  const handleDropdownClick = (e) => {
    if (!isMobile) return;

    const item = e.target.closest('.header-nav-item.has-dropdown');
    if (!item) return;

    const link = item.querySelector('.header-nav-link');
    if (!link) return;

    if (e.target === link || link.contains(e.target)) {
      e.preventDefault();

      document
        .querySelectorAll('.header-nav-item.has-dropdown.is-open')
        .forEach((openItem) => {
          if (openItem !== item) {
            openItem.classList.remove('is-open');
          }
        });

      item.classList.toggle('is-open');
    }
  };

  const handleScroll = () => {
    header.classList.toggle('is-scrolled', window.scrollY > 10);
  };

  const handleResize = () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
      const wasIsMobile = isMobile;
      isMobile = window.innerWidth <= 1023.98;

      if (wasIsMobile && !isMobile) {
        closeMobileMenu();
      }
    }, 150);
  };

  const handleKeydown = (e) => {
    if (e.key === 'Escape') {
      closeMobileMenu();
    }
  };

  const setActiveNavItem = () => {
    const currentPath = window.location.pathname;

    document.querySelectorAll('.header-nav-item').forEach((item) => {
      const link = item.querySelector('.header-nav-link');
      if (link) {
        const href = link.getAttribute('href');
        if (href && href !== '/' && currentPath.includes(href)) {
          item.classList.add('is-current');
        }
      }
    });

    document.querySelectorAll('.header-nav-dropdown-item').forEach((link) => {
      const href = link.getAttribute('href');
      if (href && currentPath.includes(href)) {
        link.classList.add('is-active');
        const parentDropdown = link.closest('.header-nav-item.has-dropdown');
        if (parentDropdown) {
          parentDropdown.classList.add('is-current');
        }
      }
    });
  };

  mobileToggle.addEventListener('click', toggleMobileMenu);
  mainNav.addEventListener('click', handleDropdownClick);
  window.addEventListener('scroll', handleScroll, { passive: true });
  window.addEventListener('resize', handleResize);
  document.addEventListener('keydown', handleKeydown);

  mainNav.querySelectorAll('.header-nav-dropdown-item').forEach((link) => {
    link.addEventListener('click', () => {
      if (isMobile) closeMobileMenu();
    });
  });

  handleScroll();
  setActiveNavItem();
});
