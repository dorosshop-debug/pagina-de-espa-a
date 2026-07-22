/**
 * Preview: relacionados / mas productos con card Home.
 */
(function () {
    if (typeof previewProducts === 'undefined' || typeof previewHomeProductCardHtml !== 'function') return;
    var path = '../theme/Doro_theme_oficial/assets/images/products/';

    function fill(id, start, count) {
        var grid = document.getElementById(id);
        if (!grid) return;
        previewProducts.slice(start, start + count).forEach(function (p, i) {
            var index = start + i;
            var li = document.createElement('li');
            li.className = 'product home-product-card';
            li.setAttribute('data-product-id', String(index));
            li.innerHTML = previewHomeProductCardHtml(p, index, path);
            grid.appendChild(li);
        });
    }

    fill('product-related-grid', 6, 4);
    fill('product-more-grid', 0, 8);
})();
