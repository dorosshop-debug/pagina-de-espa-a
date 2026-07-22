(function () {
    var grid = document.getElementById('shop-products-grid');
    if (!grid || typeof previewProducts === 'undefined' || typeof previewHomeProductCardHtml !== 'function') return;

    var productsPath = '../theme/Doro_theme_oficial/assets/images/products/';

    previewProducts.slice(0, 12).forEach(function (product, index) {
        var li = document.createElement('li');
        li.className = 'product home-product-card';
        li.setAttribute('data-product-id', String(index));
        li.innerHTML = previewHomeProductCardHtml(product, index, productsPath);
        grid.appendChild(li);
    });
})();
