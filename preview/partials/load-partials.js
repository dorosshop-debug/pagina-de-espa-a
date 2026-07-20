/**
 * Carga partials HTML en el preview (requiere servidor HTTP local).
 * Uso: <div data-include="partials/footer.html"></div>
 */
(function () {
    function loadIncludes() {
        var nodes = document.querySelectorAll('[data-include]');
        if (!nodes.length) return Promise.resolve();

        return Promise.all(Array.prototype.map.call(nodes, function (el) {
            var src = el.getAttribute('data-include');
            if (!src) return Promise.resolve();
            return fetch(src, { credentials: 'same-origin' })
                .then(function (res) {
                    if (!res.ok) throw new Error('Include failed: ' + src);
                    return res.text();
                })
                .then(function (html) {
                    var wrap = document.createElement('div');
                    wrap.innerHTML = html.trim();
                    var frag = document.createDocumentFragment();
                    while (wrap.firstChild) {
                        frag.appendChild(wrap.firstChild);
                    }
                    el.replaceWith(frag);
                })
                .catch(function () {
                    el.innerHTML = '<!-- No se pudo cargar ' + src + '. Abre el preview con abrir-preview.bat -->';
                });
        }));
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            loadIncludes().then(function () {
                document.dispatchEvent(new CustomEvent('doroshopping:partials-loaded'));
            });
        });
    } else {
        loadIncludes();
    }
})();
