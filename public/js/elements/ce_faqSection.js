document.addEventListener('DOMContentLoaded', function () {
  const faqSections = document.querySelectorAll('.ce_faqSection');

  faqSections.forEach((section) => {
    const faqAccordions = section.querySelectorAll('.faq-accordion');

    faqAccordions.forEach((accordion) => {
      const question = accordion.querySelector('.faq-question');

      question.addEventListener('click', () => {
        const isActive = accordion.classList.contains('active');

        // Close all accordions in this section
        faqAccordions.forEach((otherAccordion) => {
          otherAccordion.classList.remove('active');
        });

        // Toggle current accordion (if it wasn't active)
        if (!isActive) {
          accordion.classList.add('active');
        }
      });
    });
  });
});
