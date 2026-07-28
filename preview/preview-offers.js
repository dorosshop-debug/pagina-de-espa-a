(function () {
    var list = document.getElementById('offers-suggested-products');
    if (!list || typeof previewProducts === 'undefined') return;

    var productsPath = '../theme/Doro_theme_oficial/assets/images/products/';
    previewProducts.slice(0, 12).forEach(function (product, index) {
        var li = document.createElement('li');
        li.className = 'product home-product-card';
        li.innerHTML = previewHomeProductCardHtml(product, index + 1, productsPath);
        list.appendChild(li);
    });
})();
