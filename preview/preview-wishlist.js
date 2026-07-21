/**
 * Preview: lista de deseos con productos mock (localStorage).
 */
(function () {
    var grid = document.getElementById('wishlist-grid');
    var empty = document.getElementById('wishlist-empty');
    if (!grid || typeof previewProducts === 'undefined') return;

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

    // Seed demo products if empty (first visit)
    var ids = readIds();
    if (!ids.length) {
        ids = [0, 3, 7];
        writeIds(ids);
    }

    function render() {
        var current = readIds();
        grid.innerHTML = '';

        var items = current.map(function (i) {
            return previewProducts[i];
        }).filter(Boolean);

        if (!items.length) {
            grid.hidden = true;
            if (empty) empty.hidden = false;
            return;
        }

        grid.hidden = false;
        if (empty) empty.hidden = true;

        items.forEach(function (product, idx) {
            var realIndex = current[idx];
            var li = document.createElement('li');
            li.className = 'doro-wishlist__item';
            li.innerHTML =
                '<a class="doro-wishlist__media" href="product.html">' +
                    '<img src="' + productsPath + product.image + '" alt="' + product.name + '">' +
                '</a>' +
                '<div class="doro-wishlist__body">' +
                    '<p class="doro-wishlist__price">EUR ' + product.price + '</p>' +
                    '<h2 class="doro-wishlist__name"><a href="product.html">' + product.name + '</a></h2>' +
                    '<div class="doro-wishlist__actions">' +
                        '<a href="product.html" class="doro-wishlist__cart-btn">Ver producto</a>' +
                        '<button type="button" class="doro-wishlist__remove" data-wish-index="' + realIndex + '">Eliminar</button>' +
                    '</div>' +
                '</div>';
            grid.appendChild(li);
        });
    }

    grid.addEventListener('click', function (e) {
        var btn = e.target.closest('[data-wish-index]');
        if (!btn) return;
        var index = parseInt(btn.getAttribute('data-wish-index'), 10);
        var next = readIds().filter(function (id) { return id !== index; });
        writeIds(next);
        render();
    });

    render();
})();
