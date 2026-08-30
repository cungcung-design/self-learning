@php
    $toasts = [];
    $addToast = function (string $type, mixed $text) use (&$toasts): void {
        $text = trim((string) $text);
        if ($text === '') {
            return;
        }

        if (preg_match('/SQLSTATE|Exception|stack trace|\\\\vendor\\\\|Illuminate\\\\|PDOException|Undefined |Parse error/i', $text)) {
            $type = 'error';
            $text = 'Something went wrong. Please try again.';
        }

        $key = $type.'|'.$text;
        foreach ($toasts as $toast) {
            if ($toast['type'].'|'.$toast['text'] === $key) {
                return;
            }
        }

        $toasts[] = ['type' => $type, 'text' => $text];
    };

    $addToast('success', session('success') ?? session('message'));
    $addToast('error', session('error'));
    $addToast('warning', session('warning'));
    $addToast('info', session('info'));

    if ($errors->any() && ! session('error') && ! session('warning') && request()->routeIs('admin.*')) {
        $addToast('warning', 'Unable to save changes. Please try again.');
    }
@endphp

<div class="site-toast-stack" id="site-toast-stack" aria-live="polite" aria-atomic="false"></div>

<style>
  .site-toast-stack {
    position: fixed;
    top: 16px;
    right: 16px;
    z-index: 4000;
    display: flex;
    flex-direction: column;
    gap: 10px;
    width: min(380px, calc(100vw - 24px));
    pointer-events: none;
  }

  .site-toast {
    pointer-events: auto;
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 12px 12px 12px 14px;
    border-radius: 14px;
    background: #ffffff;
    color: #0f172a;
    box-shadow: 0 14px 40px rgba(15, 23, 42, 0.16);
    border: 1px solid #e2e8f0;
    animation: siteToastIn 0.28s ease;
  }

  .site-toast.is-leaving {
    animation: siteToastOut 0.22s ease forwards;
  }

  .site-toast__icon {
    width: 28px;
    height: 28px;
    border-radius: 999px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 14px;
    font-weight: 800;
    line-height: 1;
  }

  .site-toast__body {
    flex: 1;
    min-width: 0;
    padding-top: 4px;
    font-size: 13px;
    font-weight: 600;
    line-height: 1.45;
  }

  .site-toast__close {
    flex-shrink: 0;
    width: 28px;
    height: 28px;
    border: none;
    background: transparent;
    color: #64748b;
    border-radius: 8px;
    cursor: pointer;
    font-size: 18px;
    line-height: 1;
  }

  .site-toast__close:hover {
    background: #f1f5f9;
    color: #0f172a;
  }

  .site-toast--success { border-color: #bbf7d0; }
  .site-toast--success .site-toast__icon { background: #dcfce7; color: #15803d; }
  .site-toast--error { border-color: #fecaca; }
  .site-toast--error .site-toast__icon { background: #fee2e2; color: #b91c1c; }
  .site-toast--warning { border-color: #fde68a; }
  .site-toast--warning .site-toast__icon { background: #fef3c7; color: #b45309; }
  .site-toast--info { border-color: #bfdbfe; }
  .site-toast--info .site-toast__icon { background: #dbeafe; color: #1d4ed8; }

  @keyframes siteToastIn {
    from { opacity: 0; transform: translateY(-8px) translateX(12px); }
    to { opacity: 1; transform: none; }
  }

  @keyframes siteToastOut {
    from { opacity: 1; transform: none; }
    to { opacity: 0; transform: translateY(-6px) translateX(8px); }
  }

  @media (max-width: 640px) {
    .site-toast-stack {
      top: 12px;
      right: 12px;
      left: 12px;
      width: auto;
    }
  }

  @media (prefers-reduced-motion: reduce) {
    .site-toast,
    .site-toast.is-leaving {
      animation: none;
    }
  }
</style>

<script>
  window.__siteToasts = @json($toasts);
  window.showSiteToast = window.showSiteToast || function () {};
  (function () {
    const stack = document.getElementById('site-toast-stack');
    if (! stack) {
      return;
    }

    const active = new Set();
    const duration = 3500;
    const icons = { success: '✓', error: '!', warning: '!', info: 'i' };

    window.showSiteToast = function (type, text) {
      const allowed = ['success', 'error', 'warning', 'info'];
      type = allowed.indexOf(type) === -1 ? 'info' : type;
      text = String(text || '').trim();
      if (! text) {
        return;
      }

      const key = type + '|' + text;
      if (active.has(key)) {
        return;
      }
      active.add(key);

      const toast = document.createElement('div');
      toast.className = 'site-toast site-toast--' + type;
      toast.setAttribute('role', type === 'error' || type === 'warning' ? 'alert' : 'status');

      const icon = document.createElement('span');
      icon.className = 'site-toast__icon';
      icon.setAttribute('aria-hidden', 'true');
      icon.textContent = icons[type] || 'i';

      const body = document.createElement('div');
      body.className = 'site-toast__body';
      body.textContent = text;

      const close = document.createElement('button');
      close.type = 'button';
      close.className = 'site-toast__close';
      close.setAttribute('aria-label', 'Close notification');
      close.innerHTML = '&times;';

      toast.appendChild(icon);
      toast.appendChild(body);
      toast.appendChild(close);
      stack.appendChild(toast);

      const dismiss = function () {
        if (toast.classList.contains('is-leaving')) {
          return;
        }
        toast.classList.add('is-leaving');
        window.setTimeout(function () {
          toast.remove();
          active.delete(key);
        }, 220);
      };

      close.addEventListener('click', dismiss);
      window.setTimeout(dismiss, duration);
    };

    (window.__siteToasts || []).forEach(function (toast) {
      window.showSiteToast(toast.type, toast.text);
    });
  })();
</script>
