/**
 * tema.js — Gestión del tema claro/oscuro para SmashCode
 * Persiste la preferencia en localStorage y aplica el data-theme al <html>
 */
(function () {
  'use strict';

  const STORAGE_KEY = 'smashcode_tema';
  const TEMA_CLARO  = 'light';
  const TEMA_OSCURO = 'dark';

  /* ── Aplicar tema guardado inmediatamente (antes del paint) ── */
  const temaGuardado = localStorage.getItem(STORAGE_KEY) || TEMA_OSCURO;
  document.documentElement.setAttribute('data-theme', temaGuardado);

  /* ── Lógica del botón ── */
  function inicializarBoton() {
    const btn = document.getElementById('btn-cambiar-tema');
    if (!btn) return;

    /* Sincronizar ícono y tooltip al cargar */
    _actualizarBoton(btn, document.documentElement.getAttribute('data-theme'));

    btn.addEventListener('click', function () {
      const temaActual = document.documentElement.getAttribute('data-theme');
      const nuevoTema  = temaActual === TEMA_OSCURO ? TEMA_CLARO : TEMA_OSCURO;

      document.documentElement.setAttribute('data-theme', nuevoTema);
      localStorage.setItem(STORAGE_KEY, nuevoTema);
      _actualizarBoton(btn, nuevoTema);

      /* Animación del botón */
      btn.classList.add('tema-btn--animando');
      btn.addEventListener('animationend', () => {
        btn.classList.remove('tema-btn--animando');
      }, { once: true });
    });
  }

  function _actualizarBoton(btn, tema) {
    const icono   = btn.querySelector('.tema-icono');
    const etiqueta = btn.querySelector('.tema-label');
    if (tema === TEMA_CLARO) {
      if (icono)    icono.className   = 'fas fa-moon tema-icono';
      if (etiqueta) etiqueta.textContent = 'Oscuro';
      btn.setAttribute('aria-label', 'Cambiar a modo oscuro');
      btn.setAttribute('title',      'Cambiar a modo oscuro');
    } else {
      if (icono)    icono.className   = 'fas fa-sun tema-icono';
      if (etiqueta) etiqueta.textContent = 'Claro';
      btn.setAttribute('aria-label', 'Cambiar a modo claro');
      btn.setAttribute('title',      'Cambiar a modo claro');
    }
  }

  /* Inicializar cuando el DOM esté listo */
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', inicializarBoton);
  } else {
    inicializarBoton();
  }
})();
