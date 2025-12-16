/**
 * admin.js
 * Gestión del panel administrativo (sin frameworks)
 * - Selecciona botones .menu-btn
 * - Usa data-target="sectionId" para mapear al <div id="sectionId" class="content-section">
 * - Activa/desactiva secciones y botones
 * - Añade accesibilidad básica (tecla Enter/Space)
 */

document.addEventListener('DOMContentLoaded', () => {
  const botonesMenu = Array.from(document.querySelectorAll('.menu-btn'));
  const secciones = Array.from(document.querySelectorAll('.content-section'));

  if (!botonesMenu.length || !secciones.length) {
    // nothing to do
    return;
  }

  // Helper: desactiva todos los botones y secciones
  function clearActive() {
    botonesMenu.forEach(btn => btn.classList.remove('active-btn'));
    secciones.forEach(sec => sec.classList.remove('active-section'));
  }

  // Añadido: aplica la animación "pop" de forma temporal y reiniciable
  function triggerPopAnimation(el) {
    if (!el) return;
    // eliminar si ya existe para forzar reinicio
    el.classList.remove('pop-anim');
    // forzar reflow para reiniciar animación
    void el.offsetWidth;
    el.classList.add('pop-anim');
    // limpiar al terminar la animación
    const onEnd = () => {
      el.classList.remove('pop-anim');
      el.removeEventListener('animationend', onEnd);
    };
    el.addEventListener('animationend', onEnd);
  }

  // Activa sección por id (sin #)
  function activateSectionById(id) {
    const target = document.getElementById(id);
    if (!target) return;
    clearActive();
    target.classList.add('active-section');

    const btn = botonesMenu.find(b => (b.dataset.target || '') === id);
    if (btn) btn.classList.add('active-btn');

    // animaciones: se anima tanto la sección como el botón
    triggerPopAnimation(target);
    if (btn) triggerPopAnimation(btn);

    // accesibilidad: enfocar primer elemento interactivo de la sección
    const focusable = target.querySelector('button, [href], input, select, textarea');
    if (focusable) focusable.focus();
  }

  // Attach listeners to buttons
  botonesMenu.forEach(boton => {
    // click
    boton.addEventListener('click', (e) => {
      e.preventDefault();
      const targetId = boton.dataset.target;
      if (targetId) activateSectionById(targetId);
    });

    // keyboard support: Enter / Space
    boton.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        boton.click();
      }
    });
  });

  // Initialize: if any button already tiene class active-btn o data-default="true", úsala;
  // si no, activa la primera sección.
  const btnDefault = botonesMenu.find(b => b.classList.contains('active-btn') || b.dataset.default === 'true');
  if (btnDefault && btnDefault.dataset.target) {
    activateSectionById(btnDefault.dataset.target);
  } else {
    const firstTarget = botonesMenu[0] && botonesMenu[0].dataset.target;
    if (firstTarget) activateSectionById(firstTarget);
  }
});
