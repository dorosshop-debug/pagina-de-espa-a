/**
 * Preview: datos y render de páginas de categoría.
 * URL: category.html?c=electronica|informatica|hogar|deportes|promociones
 */
var previewCategories = {
    electronica: {
        title: 'Electrónica',
        subs: [
            { name: 'Teléfonos móviles', image: 'Producto1.jpg' },
            { name: 'Tabletas', image: 'Producto6.jpg' },
            { name: 'Auriculares', image: 'Producto1.jpg' },
            { name: 'Relojes inteligentes', image: 'Producto8.jpg' },
            { name: 'Barras de sonido', image: 'Producto7.jpg' },
            { name: 'Cámaras', image: 'Producto4.jpg' },
            { name: 'Accesorios móvil', image: 'Producto3.jpg' },
            { name: 'Cargadores', image: 'Producto3.jpg' },
            { name: 'Altavoces', image: 'Producto7.jpg' },
            { name: 'Powerbanks', image: 'Producto5.jpg' },
            { name: 'Fundas', image: 'Producto1.jpg' },
            { name: 'Memorias', image: 'Producto2.png' }
        ],
        products: [0, 2, 5, 7, 6, 11, 8, 15, 12, 16, 17, 22]
    },
    informatica: {
        title: 'Informática',
        subs: [
            { name: 'Portátiles', image: 'Producto2.png' },
            { name: 'Monitores', image: 'Producto2.png' },
            { name: 'Teclados', image: 'Producto4.jpg' },
            { name: 'Ratones', image: 'Producto5.jpg' },
            { name: 'Almacenamiento', image: 'Producto3.jpg' },
            { name: 'Routers', image: 'Producto2.png' },
            { name: 'Impresoras', image: 'Producto5.jpg' },
            { name: 'Webcams', image: 'Producto4.jpg' },
            { name: 'Hubs USB', image: 'Producto1.jpg' },
            { name: 'Soportes', image: 'Producto3.jpg' },
            { name: 'Mochilas', image: 'Producto4.jpg' },
            { name: 'Componentes', image: 'Producto6.jpg' }
        ],
        products: [1, 3, 4, 9, 12, 13, 16, 17, 18, 19, 10, 14]
    },
    hogar: {
        title: 'Hogar y Cocina',
        subs: [
            { name: 'Cafeteras', image: 'Producto6.jpg' },
            { name: 'Aspiradoras', image: 'Producto7.jpg' },
            { name: 'Iluminación', image: 'Producto6.jpg' },
            { name: 'Seguridad WiFi', image: 'Producto4.jpg' },
            { name: 'Organizadores', image: 'Producto3.jpg' },
            { name: 'Ventiladores', image: 'Producto5.jpg' },
            { name: 'Limpieza', image: 'Producto7.jpg' },
            { name: 'Gadgets cocina', image: 'Producto6.jpg' },
            { name: 'Termos', image: 'Producto1.jpg' },
            { name: 'Básculas', image: 'Producto8.jpg' },
            { name: 'Humidificadores', image: 'Producto5.jpg' },
            { name: 'Planchas', image: 'Producto7.jpg' }
        ],
        products: [6, 11, 13, 14, 20, 21, 18, 7, 5, 12, 15, 0]
    },
    deportes: {
        title: 'Deportes y Recreación',
        subs: [
            { name: 'Fitness', image: 'Producto8.jpg' },
            { name: 'Outdoor', image: 'Producto5.jpg' },
            { name: 'Ciclismo', image: 'Producto4.jpg' },
            { name: 'Yoga', image: 'Producto6.jpg' },
            { name: 'Running', image: 'Producto8.jpg' },
            { name: 'Camping', image: 'Producto7.jpg' },
            { name: 'Pesas', image: 'Producto5.jpg' },
            { name: 'Botellas', image: 'Producto1.jpg' },
            { name: 'Mochilas', image: 'Producto4.jpg' },
            { name: 'Wearables', image: 'Producto8.jpg' },
            { name: 'Accesorios', image: 'Producto3.jpg' },
            { name: 'Recreación', image: 'Producto6.jpg' }
        ],
        products: [7, 19, 14, 20, 5, 8, 23, 4, 11, 15, 6, 18]
    },
    promociones: {
        title: 'Promociones & Ofertas',
        subs: [
            { name: 'Súper Ofertas', image: 'Producto1.jpg' },
            { name: 'Liquidación', image: 'Producto3.jpg' },
            { name: 'Novedades', image: 'Producto6.jpg' },
            { name: 'Reacondicionados', image: 'Producto2.png' },
            { name: 'Packs', image: 'Producto4.jpg' },
            { name: 'Flash', image: 'Producto7.jpg' },
            { name: 'Top ventas', image: 'Producto8.jpg' },
            { name: 'Envío gratis', image: 'Producto5.jpg' },
            { name: 'Outlet tech', image: 'Producto2.png' },
            { name: 'Gaming', image: 'Producto4.jpg' },
            { name: 'Audio', image: 'Producto1.jpg' },
            { name: 'Hogar', image: 'Producto7.jpg' }
        ],
        products: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
    }
};

(function () {
    var params = new URLSearchParams(window.location.search);
    var slug = params.get('c') || 'electronica';
    var data = previewCategories[slug] || previewCategories.electronica;
    var productsPath = '../theme/Doro_theme_oficial/assets/images/products/';

    var titleEl = document.querySelector('[data-category-title]');
    if (titleEl) {
        titleEl.textContent = data.title;
    }
    document.title = 'Doroshopping - ' + data.title;

    var subsGrid = document.querySelector('[data-category-subs]');
    if (subsGrid) {
        subsGrid.innerHTML = data.subs.map(function (sub) {
            return (
                '<a class="doro-category__sub" href="shop.html">' +
                    '<span class="doro-category__sub-circle">' +
                        '<img src="' + productsPath + sub.image + '" alt="" loading="lazy" width="88" height="88">' +
                    '</span>' +
                    '<span class="doro-category__sub-label">' + sub.name + '</span>' +
                '</a>'
            );
        }).join('');
    }

    var productsGrid = document.querySelector('[data-category-products]');
    if (!productsGrid || typeof previewProducts === 'undefined') return;

    var wishSvg = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"/></svg>';

    productsGrid.innerHTML = '';
    data.products.forEach(function (index) {
        var product = previewProducts[index];
        if (!product) return;
        var li = document.createElement('li');
        li.className = 'product doro-product-card';
        li.innerHTML =
            '<div class="doro-product-card__media">' +
                '<a href="product.html"><img src="' + productsPath + product.image + '" alt="' + product.name + '"></a>' +
                '<button type="button" class="doro-product-card__wish-btn" data-wishlist-toggle data-product-id="' + index + '" aria-pressed="false" aria-label="Anadir a lista de deseos">' + wishSvg + '</button>' +
            '</div>' +
            '<div class="doro-product-card__body">' +
                '<span class="price">' + product.price + ' EUR</span>' +
                '<h2 class="woocommerce-loop-product__title"><a href="product.html">' + product.name + '</a></h2>' +
            '</div>';
        productsGrid.appendChild(li);
    });
})();
