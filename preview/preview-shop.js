(function () {
    var grid = document.getElementById('shop-products-grid');
    if (!grid || typeof previewProducts === 'undefined') return;

    var productsPath = '../theme/doroshopping/assets/images/products/';

    previewProducts.slice(0, 12).forEach(function (product) {
        var li = document.createElement('li');
        li.className = 'product doro-product-card';
        li.innerHTML =
            '<a href="product.html" class="woocommerce-LoopProduct-link">' +
                '<div class="doro-product-card__media">' +
                    '<img src="' + productsPath + product.image + '" alt="' + product.name + '">' +
                '</div>' +
                '<div class="doro-product-card__body">' +
                    '<span class="price">EUR ' + product.price + '</span>' +
                    (typeof previewStarRatingHtml === 'function' ? previewStarRatingHtml(product.rating, product.reviews) : '') +
                    '<h2 class="woocommerce-loop-product__title">' + product.name + '</h2>' +
                '</div>' +
            '</a>';
        grid.appendChild(li);
    });
})();
