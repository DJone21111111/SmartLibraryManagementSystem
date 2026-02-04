(function () {
  // confirm delete
  document.querySelectorAll('[data-js="confirm-delete"]').forEach(btn => {
    btn.addEventListener('click', (e) => {
      const ok = confirm('Delete this item?');
      if (!ok) e.preventDefault();
    });
  });

  const coverInput = document.querySelector('[data-js="cover-url"]');
  const coverPreview = document.querySelector('[data-js="cover-preview"]');

  if (coverInput && coverPreview) {
    const update = () => {
      const url = coverInput.value.trim();
      if (url) coverPreview.src = url;
    };
    coverInput.addEventListener('input', update);
    update();
  }
})();
