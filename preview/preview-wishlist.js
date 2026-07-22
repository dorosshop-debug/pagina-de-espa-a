/**
 * Preview: lista de deseos con cards estilo Home.
 */
(function () {
    var grid = document.getElementById('wishlist-grid');
    var empty = document.getElementById('wishlist-empty');
    if (!grid || typeof previewProducts === 'undefined' || typeof previewHomeProductCardHtml !== 'function') return;

    var KEY = 'doroshopping_wishlist_preview';
    var productsPath = '../theme/Doro_theme_oficial/assets/images/products/';

    function readIds() {
        try {
            var raw = localStorage.getItem(KEY);
            var ids = raw ? JSON.parse(raw) : [];
            return Array.isArray(ids) ? ids : [];
        } catch (e) {
            return [];
        }
    }

    function writeIds(ids) {
        localStorage.setItem(KEY, JSON.stringify(ids));
    }

    var ids = readIds();
    if (!ids.length) {
        ids = [0, 3, 7];
        writeIds(ids);
    }

    function render() {
        var current = readIds();
        grid.innerHTML = '';

        if (!current.length) {
            grid.hidden = true;
            if (empty) empty.hidden = false;
            return;
        }

        grid.hidden = false;
        if (empty) empty.hidden = true;
        grid.className = 'products columns-4 doro-wishlist__grid';

        current.forEach(function (index) {
            var product = previewProducts[index];
            if (!product) return;
            var li = document.createElement('li');
            li.className = 'product home-product-card';
            li.setAttribute('data-product-id', String(index));
            li.innerHTML = previewHomeProductCardHtml(product, index, productsPath);
            // Marcar wishlist activo
            var wish = li.querySelector('[data-wishlist-toggle]');
            if (wish) {
                wish.classList.add('is-active');
                wish.setAttribute('aria-pressed', 'true');
            }
            grid.appendChild(li);
        });
    }

    render();
})();
