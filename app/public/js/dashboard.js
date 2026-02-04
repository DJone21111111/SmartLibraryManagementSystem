(function () {
  // confirm return
  document.querySelectorAll('[data-js="confirm-return"]').forEach(btn => {
    btn.addEventListener('click', (e) => {
      const ok = confirm('Return this book?');
      if (!ok) e.preventDefault();
    });
  });

  // need to look at this later
  // confirm cancel reservation (if you add it later)
  document.querySelectorAll('[data-js="confirm-cancel"]').forEach(btn => {
    btn.addEventListener('click', (e) => {
      const ok = confirm('Cancel this reservation?');
      if (!ok) e.preventDefault();
    });
  });
})();
