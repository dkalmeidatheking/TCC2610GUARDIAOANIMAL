document.addEventListener('DOMContentLoaded', () => {
  const menu = document.querySelector('.menu');
  const nav = document.querySelector('.main-nav');
  const header = document.querySelector('.site-header');

  if (menu && nav) {
    menu.addEventListener('click', () => {
      const open = nav.classList.toggle('open');
      menu.setAttribute('aria-expanded', open ? 'true' : 'false');
      document.body.classList.toggle('menu-open', open);
    });

    nav.querySelectorAll('a').forEach(link => link.addEventListener('click', () => {
      nav.classList.remove('open');
      menu.setAttribute('aria-expanded', 'false');
      document.body.classList.remove('menu-open');
    }));
  }

  const onScroll = () => {
    if (header) header.classList.toggle('scrolled', window.scrollY > 12);
  };
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  document.querySelectorAll('.ong-grid .ong-card, .story-grid > *, .about-decisions .decision, .flow-line .flow-step').forEach(el => el.classList.add('reveal'));

  const revealItems = document.querySelectorAll('.reveal');
  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries, obs) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          obs.unobserve(entry.target);
        }
      });
    }, { threshold: 0.10, rootMargin: '0px 0px -35px 0px' });
    revealItems.forEach(el => observer.observe(el));
  } else {
    revealItems.forEach(el => el.classList.add('is-visible'));
  }

  document.querySelectorAll('[data-toast]').forEach(toast => {
    setTimeout(() => toast.remove(), 5000);
  });

  document.querySelectorAll('.filter').forEach(btn => btn.addEventListener('click', () => {
    document.querySelectorAll('.filter').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    const value = btn.dataset.filter;
    document.querySelectorAll('[data-item]').forEach(card => {
      const show = value === 'todos' || card.dataset.item === value;
      card.style.display = show ? '' : 'none';
    });
  }));

  document.querySelectorAll('[data-copy]').forEach(btn => btn.addEventListener('click', async () => {
    try {
      await navigator.clipboard.writeText(btn.dataset.copy);
      const old = btn.textContent;
      btn.textContent = 'Copiado';
      setTimeout(() => btn.textContent = old, 1600);
    } catch (e) {
      window.prompt('Copie a chave:', btn.dataset.copy);
    }
  }));

  // contadores da faixa de números
  const counters = document.querySelectorAll('.count-up[data-count]');
  if ('IntersectionObserver' in window && counters.length) {
    const counterObserver = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (!entry.isIntersecting || entry.target.dataset.done) return;
        entry.target.dataset.done = '1';
        const target = Number(entry.target.dataset.count || 0);
        const start = performance.now();
        const duration = 900;
        const tick = now => {
          const progress = Math.min((now - start) / duration, 1);
          const eased = 1 - Math.pow(1 - progress, 3);
          entry.target.textContent = Math.round(target * eased);
          if (progress < 1) requestAnimationFrame(tick);
        };
        requestAnimationFrame(tick);
      });
    }, { threshold: .7 });
    counters.forEach(el => counterObserver.observe(el));
  }

  // movimento leve da hero enquanto a página rola
  const hero = document.querySelector('.home-hero:after');
  window.addEventListener('scroll', () => {
    if (window.innerWidth < 900) return;
    const y = Math.min(window.scrollY * 0.10, 42);
    document.documentElement.style.setProperty('--hero-shift', `${y}px`);
  }, { passive: true });

  // teclado: Esc fecha o menu
  document.addEventListener('keydown', event => {
    if (event.key === 'Escape' && nav && nav.classList.contains('open')) {
      nav.classList.remove('open');
      if (menu) menu.setAttribute('aria-expanded', 'false');
    }
  });
});
