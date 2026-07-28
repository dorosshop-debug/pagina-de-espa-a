/**
 * Simula estados de sesión en el preview estático.
 * ?logged=1  → oculta "Crear una cuenta" en el footer (usuario logueado).
 */
(function () {
    var params = new URLSearchParams(window.location.search);
    if (params.get('logged') === '1') {
        document.documentElement.classList.add('is-user-logged-in');
    }

    var style = document.createElement('style');
    style.textContent =
        '.is-user-logged-in .site-footer__link-create-account{display:none!important}' +
        '.preview-toolbar{position:fixed;bottom:16px;left:16px;z-index:9999;display:flex;flex-wrap:wrap;gap:8px;max-width:min(92vw,420px)}' +
        '.preview-toolbar a,.preview-toolbar span{font:600 12px/1.2 system-ui,sans-serif;padding:8px 12px;border-radius:999px;text-decoration:none;border:1px solid #ddd;background:#fff;color:#222;box-shadow:0 4px 14px rgba(0,0,0,.12)}' +
        '.preview-toolbar a:hover{border-color:#f97316;color:#f97316}' +
        '.preview-toolbar .is-active{background:#111;color:#fff;border-color:#111}';
    document.head.appendChild(style);

    if (!document.querySelector('.preview-toolbar')) {
        var bar = document.createElement('div');
        bar.className = 'preview-toolbar';
        bar.setAttribute('aria-label', 'Herramientas de preview');
        var path = window.location.pathname.replace(/\\/g, '/');
        var page = path.substring(path.lastIndexOf('/') + 1) || 'index.html';
        var base = page.split('?')[0];
        var logged = params.get('logged') === '1';
        bar.innerHTML =
            '<span>Preview local</span>' +
            '<a href="' + base + (logged ? '' : '?logged=1') + '"' + (logged ? '' : ' class="is-active"') + '>Invitado</a>' +
            '<a href="' + base + '?logged=1"' + (logged ? ' class="is-active"' : '') + '>Logueado</a>' +
            '<a href="account-password.html">Crear contraseña</a>' +
            '<a href="account-logged.html">Mi cuenta</a>' +
            '<a href="offers.html' + (logged ? '?logged=1' : '') + '">Ofertas vacías</a>' +
            '<a href="coupons.html">Cupones</a>' +
            '<a href="help.html">Ayuda</a>' +
            '<a href="faq.html">FAQ</a>' +
            '<a href="index.html' + (logged ? '?logged=1' : '') + '">Home</a>';
        document.body.appendChild(bar);
    }
})();
