(function () {
  const pageSelector = '[data-public-page]';
  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  let currentPathname = window.location.pathname;
  let navigationRequest = null;

  const wait = (ms) => new Promise((resolve) => setTimeout(resolve, ms));

  const sameLocation = (left, right) => {
    const a = new URL(left, window.location.origin);
    const b = new URL(right, window.location.origin);
    return a.pathname === b.pathname && a.search === b.search;
  };

  const isModifiedClick = (event) => (
    event.metaKey || event.ctrlKey || event.shiftKey || event.altKey || event.button !== 0
  );

  const closeMobileNav = () => {
    const collapse = document.getElementById('publicNav');
    if (!collapse || !collapse.classList.contains('show')) {
      return;
    }

    if (window.jQuery) {
      window.jQuery(collapse).collapse('hide');
      return;
    }

    collapse.classList.remove('show');
    document.querySelector('.navbar-toggler')?.setAttribute('aria-expanded', 'false');
  };

  const setActiveNav = (url) => {
    const current = new URL(url, window.location.origin);
    const currentPath = current.pathname.replace(/\/+$/, '') || '/';

    document.querySelectorAll('header .navbar-nav .nav-item').forEach((item) => {
      const link = item.querySelector(':scope > a.nav-link');
      if (!link) {
        return;
      }

      const linkPath = new URL(link.href, window.location.origin).pathname.replace(/\/+$/, '') || '/';
      const isActive = linkPath === '/'
        ? currentPath === '/'
        : currentPath === linkPath || currentPath.startsWith(linkPath + '/');

      item.classList.toggle('active', isActive);
    });
  };

  const replaceBetween = (start, end, sourceStart, sourceEnd) => {
    if (!start || !end) {
      return;
    }

    let node = start.nextSibling;
    while (node && node !== end) {
      const next = node.nextSibling;
      node.remove();
      node = next;
    }

    if (!sourceStart || !sourceEnd) {
      return;
    }

    const fragment = document.createDocumentFragment();
    node = sourceStart.nextSibling;
    while (node && node !== sourceEnd) {
      fragment.appendChild(node.cloneNode(true));
      node = node.nextSibling;
    }

    end.parentNode.insertBefore(fragment, end);
  };

  const replacePageScripts = (doc) => {
    const container = document.getElementById('public-page-scripts');
    const source = doc.getElementById('public-page-scripts');
    if (!container) {
      return Promise.resolve();
    }

    container.innerHTML = '';
    if (!source) {
      return Promise.resolve();
    }

    const scripts = Array.from(source.querySelectorAll('script'));

    return scripts.reduce((chain, oldScript) => chain.then(() => new Promise((resolve) => {
      const script = document.createElement('script');

      Array.from(oldScript.attributes).forEach((attr) => {
        script.setAttribute(attr.name, attr.value);
      });

      if (oldScript.src) {
        script.onload = () => resolve();
        script.onerror = () => resolve();
        container.appendChild(script);
        return;
      }

      script.textContent = oldScript.textContent;
      container.appendChild(script);
      resolve();
    })), Promise.resolve());
  };

  const applyDocument = async (doc, url) => {
    const nextPage = doc.querySelector(pageSelector);
    const currentPage = document.querySelector(pageSelector);

    if (!nextPage || !currentPage) {
      window.location.assign(url);
      return false;
    }

    document.dispatchEvent(new CustomEvent('public-page:leave'));

    currentPage.classList.add('is-changing');
    currentPage.setAttribute('aria-busy', 'true');

    if (!prefersReducedMotion) {
      await wait(180);
    }

    replaceBetween(
      document.getElementById('public-page-styles-start'),
      document.getElementById('public-page-styles-end'),
      doc.getElementById('public-page-styles-start'),
      doc.getElementById('public-page-styles-end')
    );

    currentPage.innerHTML = nextPage.innerHTML;
    document.title = doc.title;
    document.body.className = doc.body.className;
    setActiveNav(url);
    currentPathname = new URL(url, window.location.origin).pathname;
    window.scrollTo({ top: 0, behavior: prefersReducedMotion ? 'auto' : 'smooth' });

    await replacePageScripts(doc);

    currentPage.classList.remove('is-changing');
    currentPage.removeAttribute('aria-busy');
    return true;
  };

  const navigate = async (url, { push = false } = {}) => {
    if (navigationRequest) {
      navigationRequest.abort();
    }

    const controller = new AbortController();
    navigationRequest = controller;

    try {
      const response = await fetch(url, {
        headers: {
          Accept: 'text/html',
          'X-Public-Nav': '1',
        },
        credentials: 'same-origin',
        redirect: 'follow',
        signal: controller.signal,
      });

      const finalUrl = response.url || url;

      if (!response.ok) {
        window.location.assign(finalUrl);
        return;
      }

      const html = await response.text();
      const doc = new DOMParser().parseFromString(html, 'text/html');

      if (!doc.querySelector(pageSelector)) {
        document.querySelector(pageSelector)?.classList.add('is-changing');
        window.location.assign(finalUrl);
        return;
      }

      if (push && !sameLocation(window.location.href, finalUrl)) {
        window.history.pushState({ publicNav: true }, '', finalUrl);
      }

      await applyDocument(doc, finalUrl);
    } catch (error) {
      if (error.name === 'AbortError') {
        return;
      }
      window.location.assign(url);
    } finally {
      if (navigationRequest === controller) {
        navigationRequest = null;
      }
    }
  };

  document.addEventListener('click', (event) => {
    const link = event.target.closest('header .navbar-nav .nav-item > a.nav-link');
    if (!link) {
      return;
    }

    if (isModifiedClick(event) || link.getAttribute('target') === '_blank') {
      return;
    }

    const destination = new URL(link.href, window.location.origin);
    if (destination.origin !== window.location.origin) {
      return;
    }

    event.preventDefault();
    setActiveNav(link.href);
    closeMobileNav();

    if (sameLocation(window.location.href, link.href)) {
      return;
    }

    navigate(link.href, { push: true });
  });

  window.addEventListener('popstate', () => {
    if (window.location.pathname === currentPathname) {
      return;
    }

    navigate(window.location.href, { push: false });
  });

  setActiveNav(window.location.href);
})();
