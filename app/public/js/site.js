// Lightweight site interactions: accessible dropdowns, toasts, keyboard navigation
document.addEventListener('DOMContentLoaded', () => {
  // Toast helper
  window.showToast = function(message, type = 'info', timeout = 4000) {
    const containerId = 'site-toasts';
    let container = document.getElementById(containerId);
    if (!container) {
      container = document.createElement('div');
      container.id = containerId;
      container.style.position = 'fixed';
      container.style.right = '1rem';
      container.style.bottom = '1rem';
      container.style.display = 'flex';
      container.style.flexDirection = 'column';
      container.style.gap = '0.5rem';
      container.style.zIndex = 1050;
      document.body.appendChild(container);
    }

    const toast = document.createElement('div');
    toast.className = 'site-toast';
    toast.setAttribute('role','status');
    toast.setAttribute('aria-live','polite');
    toast.style.minWidth = '220px';
    toast.style.background = '#fff';
    toast.style.border = '1px solid rgba(0,0,0,0.08)';
    toast.style.padding = '0.6rem 0.9rem';
    toast.style.borderRadius = '8px';
    toast.style.boxShadow = '0 8px 30px rgba(15,23,42,0.06)';
    toast.style.display = 'flex';
    toast.style.alignItems = 'center';
    toast.style.justifyContent = 'space-between';
    toast.style.gap = '0.5rem';

    const text = document.createElement('div');
    text.textContent = message;
    text.style.color = '#111827';
    text.style.fontSize = '0.95rem';

    const close = document.createElement('button');
    close.className = 'btn site-toast-close';
    close.innerHTML = 'Close';
    close.style.background = 'transparent';
    close.style.border = 'none';
    close.style.cursor = 'pointer';
    close.style.color = '#374151';
    close.addEventListener('click', () => { container.removeChild(toast); });

    toast.appendChild(text);
    toast.appendChild(close);
    container.appendChild(toast);

    setTimeout(() => {
      if (toast.parentNode) {
        try { toast.style.opacity = '0'; toast.style.transform = 'translateY(8px)'; } catch(e){}
        setTimeout(() => { if (toast.parentNode) container.removeChild(toast); }, 300);
      }
    }, timeout);
  };

  // Accessible dropdowns (data-dropdown-trigger -> toggles nearest .dropdown)
  document.querySelectorAll('[data-dropdown-trigger]').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      const dropdown = btn.closest('.dropdown');
      if (!dropdown) return;
      dropdown.classList.toggle('active');
      const menu = dropdown.querySelector('.dropdown-menu');
      if (menu) {
        menu.setAttribute('aria-hidden', dropdown.classList.contains('active') ? 'false' : 'true');
      }
    });
    btn.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') { btn.closest('.dropdown')?.classList.remove('active'); }
    });
  });

  // Close dropdowns when clicking outside
  document.addEventListener('click', (e) => {
    document.querySelectorAll('.dropdown.active').forEach(dd => {
      if (!dd.contains(e.target)) dd.classList.remove('active');
    });
  });

  // Keyboard shortcut: press '/' to focus main search if present
  document.addEventListener('keydown', (e) => {
    if (e.key === '/' && document.activeElement.tagName !== 'INPUT' && document.activeElement.tagName !== 'TEXTAREA') {
      const search = document.querySelector('input[type="search"], input[data-main-search], .admin-search-input');
      if (search) { e.preventDefault(); search.focus(); search.select(); }
    }
  });

  // Make .list-card clickable if it contains a link
  document.querySelectorAll('.list-card').forEach(card => {
    const link = card.querySelector('a');
    if (!link) return;
    card.style.cursor = 'pointer';
    card.addEventListener('click', (e) => {
      if (e.target.tagName === 'A' || e.target.closest('button')) return; // ignore internal clicks
      window.location = link.getAttribute('href');
    });
    // allow keyboard activation
    card.tabIndex = 0;
    card.addEventListener('keydown', (e) => { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); link.click(); } });
  });

  // Enhance any forms with data-confirm attribute
  document.querySelectorAll('form[data-confirm]').forEach(form => {
    form.addEventListener('submit', (e) => {
      const msg = form.getAttribute('data-confirm') || 'Are you sure?';
      if (!confirm(msg)) e.preventDefault();
    });
  });

  // Auto-turn server flash message into toast if present
  try {
    const flashEl = document.querySelector('[data-flash]');
    if (flashEl) {
      const msg = flashEl.getAttribute('data-flash-message');
      const type = flashEl.getAttribute('data-flash-type') || 'info';
      if (msg) showToast(msg, type, 5000);
    }
  } catch (e) {}

});
