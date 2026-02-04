(function () {
  const input = document.querySelector('[data-js="catalog-search"]');
  const rows = document.querySelectorAll('[data-js="book-row"]');

  if (!input || rows.length === 0) return;

  input.addEventListener('input', () => {
    const q = input.value.trim().toLowerCase();

    rows.forEach(r => {
      const hay = (r.getAttribute('data-search') || '').toLowerCase();
      r.style.display = hay.includes(q) ? '' : 'none';
    });
  });
})();
