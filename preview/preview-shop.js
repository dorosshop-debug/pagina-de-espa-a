(function () {
    var grid = document.getElementById('shop-products-grid');
    if (!grid || typeof previewProducts === 'undefined') return;

    var productsPath = '../theme/Doro_theme_oficial/assets/images/products/';
    var wishSvg = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"/></svg>';

    previewProducts.slice(0, 12).forEach(function (product, index) {
        var li = document.createElement('li');
        li.className = 'product doro-product-card';
        li.innerHTML =
            '<div class="doro-product-card__media">' +
                '<a href="product.html" class="woocommerce-LoopProduct-link">' +
                    '<img src="' + productsPath + product.image + '" alt="' + product.name + '">' +
                '</a>' +
                '<button type="button" class="doro-product-card__wish-btn" data-wishlist-toggle data-product-id="' + index + '" aria-pressed="false" aria-label="Anadir a lista de deseos">' + wishSvg + '</button>' +
            '</div>' +
            '<div class="doro-product-card__body">' +
                '<a href="product.html">' +
                    '<span class="price">EUR ' + product.price + '</span>' +
                    (typeof previewStarRatingHtml === 'function' ? previewStarRatingHtml(product.rating, product.reviews) : '') +
                    '<h2 class="woocommerce-loop-product__title">' + product.name + '</h2>' +
                '</a>' +
            '</div>';
        grid.appendChild(li);
    });
})();
