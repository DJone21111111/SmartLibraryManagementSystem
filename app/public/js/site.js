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
    // Color accent based on type
    if (type === 'success') text.style.color = '#065f46';
    if (type === 'danger' || type === 'error') text.style.color = '#7f1d1d';
    if (type === 'warning') text.style.color = '#854d0e';
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
      document.addEventListener('DOMContentLoaded', () => {
        if (typeof window.showToast === 'undefined') {
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
          }

        try {
          const flashEl = document.querySelector('[data-flash]');
          if (flashEl) {
            const msg = flashEl.getAttribute('data-flash-message');
            const type = flashEl.getAttribute('data-flash-type') || 'info';
            if (msg) showToast(msg, type, 5000);
          }
        } catch (e) {}

        (function catalogViewToggle(){
          const results = document.getElementById('catalog-results');
          const viewButtons = Array.from(document.querySelectorAll('[data-view]'));
          if (!results || !viewButtons.length) return;

          const applyView = (v) => {
            results.classList.remove('list','grid');
            if (v === 'grid') {
              results.classList.add('grid');
              results.classList.remove('d-flex','flex-column');
            } else {
              results.classList.add('list');
              results.classList.add('d-flex','flex-column');
            }
            viewButtons.forEach(b => b.classList.toggle('active', b.getAttribute('data-view') === v));
          };

          const saved = localStorage.getItem('catalogView') || 'list';
          applyView(saved);

          viewButtons.forEach(btn => btn.addEventListener('click', (e) => {
            e.preventDefault();
            const v = btn.getAttribute('data-view') || 'list';
            localStorage.setItem('catalogView', v);
            applyView(v);
          }));
        })();

        (function replaceBootstrapIcons() {
          const ICON_CDN_BASE = 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/icons/';
          const icons = Array.from(document.querySelectorAll('i[class*="bi-"]'));
          if (!icons.length) return;
          const cache = new Map();

          function iconNameFromClass(cls) {
            const parts = cls.split(/\s+/).find(t => t.startsWith('bi-') && t !== 'bi');
            return parts ? parts.replace(/^bi-/, '') : null;
          }

          icons.forEach(async (el) => {
            const name = iconNameFromClass(el.className || '');
            if (!name) return;

            if (cache.has(name)) {
              el.outerHTML = cache.get(name);
              return;
            }

            try {
              const res = await fetch(ICON_CDN_BASE + name + '.svg');
              if (!res.ok) throw new Error('Not found');
              let svg = await res.text();
              const additional = Array.from(el.classList).filter(c => c !== 'bi' && !c.startsWith('bi-')).join(' ');
              svg = svg.replace('<svg', `<svg role="img" aria-hidden="true" class="bi-svg ${additional}"`);
              cache.set(name, svg);
              el.outerHTML = svg;
            } catch (err) {
            }
          });
        })();

        (function ajaxActions(){
          async function postForm(form) {
            const action = form.getAttribute('action') || window.location.pathname;
            const fd = new FormData(form);
            try {
              const res = await fetch(action, {
                method: (form.getAttribute('method') || 'POST').toUpperCase(),
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                credentials: 'same-origin',
                body: fd
              });
              if (!res.ok) throw new Error('Request failed');
              const json = await res.json().catch(() => null);
              if (json && typeof json.success !== 'undefined') {
                showToast(json.message || (json.success ? 'Done' : 'Failed'), json.success ? 'success' : 'danger', 4000);
              } else {
                showToast('Action completed.', 'success', 3000);
              }

              // If this was a loan return, remove the loan card from the page
              try {
                if (action.startsWith('/loan/return')) {
                  const card = form.closest('.card');
                  if (card) card.remove();
                  // If no more loan cards, show empty message
                  const container = document.querySelector('.container');
                  const listGroup = document.querySelector('.list-group');
                  if (!listGroup || listGroup.children.length === 0) {
                    const wrapper = document.querySelector('.container.py-4') || container;
                    if (wrapper) {
                      const msg = document.createElement('div');
                      msg.className = 'card p-4 text-muted';
                      msg.textContent = 'You have no active loans.';
                      // remove existing list/group if present
                      if (listGroup && listGroup.parentNode) listGroup.parentNode.removeChild(listGroup);
                      // append message after heading
                      const heading = wrapper.querySelector('h1');
                      if (heading && heading.nextSibling) heading.parentNode.insertBefore(msg, heading.nextSibling);
                    }
                  }
                  return;
                }
              } catch (e) {}

              setTimeout(() => window.location.reload(), 700);
            } catch (err) {
              showToast(err.message || 'Request failed', 'danger', 5000);
            }
          }

          document.addEventListener('submit', (e) => {
            const form = e.target;
            if (!(form instanceof HTMLFormElement)) return;
            const action = form.getAttribute('action') || '';
            if (action.startsWith('/loan/')) {
              e.preventDefault();
              postForm(form);
            }
            if (action === '/reserve/cancel') {
              e.preventDefault();
              postForm(form);
            }
          });

          document.querySelectorAll('.btn-cancel-reservation').forEach(btn => {
            btn.addEventListener('click', (e) => {
              const reservationId = btn.getAttribute('data-reservation-id');
              const bookId = btn.closest('form')?.querySelector('input[name="book_id"]')?.value;
              if (!reservationId || !bookId) { showToast('Invalid reservation', 'danger', 3000); return; }
              const form = document.createElement('form');
              form.method = 'post';
              form.action = '/reserve/cancel';
              const rid = document.createElement('input'); rid.type='hidden'; rid.name='reservation_id'; rid.value=reservationId; form.appendChild(rid);
              const bid = document.createElement('input'); bid.type='hidden'; bid.name='book_id'; bid.value=bookId; form.appendChild(bid);
              document.body.appendChild(form);
              postForm(form);
            });
          });
        })();

      });
