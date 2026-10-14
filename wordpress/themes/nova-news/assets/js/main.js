document.addEventListener('DOMContentLoaded', () => {
  const menuToggle = document.querySelector('.mobile-toggle');
  const navigation = document.getElementById('primary-navigation');
  if (menuToggle && navigation) {
    menuToggle.addEventListener('click', () => {
      const opened = menuToggle.getAttribute('aria-expanded') === 'true';
      menuToggle.setAttribute('aria-expanded', String(!opened));
      navigation.classList.toggle('is-open', !opened);
    });
  }
  const searchToggle = document.querySelector('.search-trigger');
  const searchPanel = document.getElementById('site-search');
  if (searchToggle && searchPanel) {
    searchToggle.addEventListener('click', () => {
      const opened = searchToggle.getAttribute('aria-expanded') === 'true';
      searchToggle.setAttribute('aria-expanded', String(!opened));
      searchPanel.hidden = opened;
      if (!opened) searchPanel.querySelector('input[type="search"]')?.focus();
    });
  }
});
