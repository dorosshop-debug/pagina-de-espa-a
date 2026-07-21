var previewProducts = [
    { price: '23.99', name: 'Auriculares Bluetooth TWS Pro', image: 'Producto1.jpg', rating: 4.5, reviews: 12 },
    { price: '45.50', name: 'Monitor LED 24 pulgadas Full HD', image: 'Producto2.png', rating: 0, reviews: 0 },
    { price: '12.99', name: 'Cable USB-C rapido carga 2m', image: 'Producto3.jpg', rating: 3, reviews: 4 },
    { price: '89.00', name: 'Teclado mecanico RGB Gaming', image: 'Producto4.jpg', rating: 5, reviews: 28 },
    { price: '34.75', name: 'Raton inalambrico ergonomico', image: 'Producto5.jpg', rating: 2.5, reviews: 3 },
    { price: '156.00', name: 'Tablet 10 pulgadas 64GB', image: 'Producto6.jpg', rating: 0, reviews: 0 },
    { price: '28.50', name: 'Altavoz portatil resistente agua', image: 'Producto7.jpg', rating: 4, reviews: 9 },
    { price: '67.99', name: 'Smartwatch deportivo GPS', image: 'Producto8.jpg', rating: 3.5, reviews: 7 },
    { price: '19.99', name: 'Funda protectora smartphone', image: 'Producto1.jpg', rating: 0, reviews: 0 },
    { price: '299.00', name: 'Portatil 15.6 8GB RAM SSD', image: 'Producto2.png', rating: 4, reviews: 15 },
    { price: '8.50', name: 'Soporte movil para coche', image: 'Producto3.jpg', rating: 1, reviews: 1 },
    { price: '42.00', name: 'Camara de seguridad WiFi', image: 'Producto4.jpg', rating: 0, reviews: 0 },
    { price: '55.25', name: 'Impresora etiquetas termica', image: 'Producto5.jpg', rating: 4.5, reviews: 6 },
    { price: '14.99', name: 'Lampara LED escritorio USB', image: 'Producto6.jpg', rating: 0, reviews: 0 },
    { price: '78.00', name: 'Aspiradora robot compacta', image: 'Producto7.jpg', rating: 5, reviews: 21 },
    { price: '31.50', name: 'Microfono condensador USB', image: 'Producto8.jpg', rating: 3, reviews: 2 },
    { price: '22.00', name: 'Hub USB 7 puertos', image: 'Producto1.jpg', rating: 0, reviews: 0 },
    { price: '95.99', name: 'Router WiFi 6 doble banda', image: 'Producto2.png', rating: 4, reviews: 11 },
    { price: '18.75', name: 'Organizador cables escritorio', image: 'Producto3.jpg', rating: 2, reviews: 1 },
    { price: '49.00', name: 'Mochila antirrobo portatil', image: 'Producto4.jpg', rating: 0, reviews: 0 },
    { price: '37.50', name: 'Ventilador de pie silencioso', image: 'Producto5.jpg', rating: 3.5, reviews: 5 },
    { price: '63.00', name: 'Proyector mini HD portatil', image: 'Producto6.jpg', rating: 4, reviews: 8 },
    { price: '11.99', name: 'Protector pantalla cristal templado', image: 'Producto7.jpg', rating: 0, reviews: 0 },
    { price: '72.50', name: 'Auriculares gaming 7.1 surround', image: 'Producto8.jpg', rating: 5, reviews: 33 }
];

function previewStarRatingHtml(rating, reviews) {
    var html = '<div class="product-rating" role="img" aria-label="' + (reviews > 0 ? 'Valoracion ' + rating + ' de 5' : 'Sin valoraciones') + '">';
    for (var i = 1; i <= 5; i++) {
        var fill = 0;
        if (reviews > 0) {
            if (rating >= i) fill = 100;
            else if (rating > i - 1) fill = (rating - (i - 1)) * 100;
        }
        html +=
            '<span class="product-rating__star" aria-hidden="true">' +
                '<svg class="product-rating__star-empty" viewBox="0 0 24 24" width="14" height="14"><path d="M12 2l2.9 6.3 6.9.8-5.1 4.7 1.4 6.8L12 17.8 5.9 20.6l1.4-6.8L2.2 9.1l6.9-.8L12 2z" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg>' +
                '<span class="product-rating__star-fill" style="width:' + fill + '%;"><svg viewBox="0 0 24 24" width="14" height="14"><path d="M12 2l2.9 6.3 6.9.8-5.1 4.7 1.4 6.8L12 17.8 5.9 20.6l1.4-6.8L2.2 9.1l6.9-.8L12 2z" fill="currentColor"/></svg></span>' +
            '</span>';
    }
    html += '</div>';
    return html;
}

(function () {
    var grid = document.getElementById('products-grid');
    if (!grid) return;

    var cartSvg = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>';
    var wishSvg = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"/></svg>';
    var productsPath = '../theme/Doro_theme_oficial/assets/images/products/';

    previewProducts.forEach(function (product, index) {
        var card = document.createElement('article');
        card.className = 'home-product-card';
        card.setAttribute('data-product-id', String(index));
        card.innerHTML =
            '<div class="home-product-card__image-wrap">' +
                '<a href="product.html" class="home-product-card__image-link">' +
                    '<img src="' + productsPath + product.image + '" alt="' + product.name + '">' +
                '</a>' +
                '<button type="button" class="home-product-card__cart-btn" aria-label="Anadir al carrito">' + cartSvg + '</button>' +
                '<button type="button" class="home-product-card__wish-btn" data-wishlist-toggle data-product-id="' + index + '" aria-pressed="false" aria-label="Anadir a lista de deseos">' + wishSvg + '</button>' +
            '</div>' +
            '<div class="home-product-card__info">' +
                '<p class="home-product-card__price">' + product.price + ' EUR</p>' +
                previewStarRatingHtml(product.rating, product.reviews) +
                '<h3 class="home-product-card__name"><a href="product.html">' + product.name + '</a></h3>' +
            '</div>';
        grid.appendChild(card);
    });
})();

(function () {
    var productsPath = '../theme/Doro_theme_oficial/assets/images/products/';
    var state = {
        items: [],
        recommendations: [
            {
                id: 2,
                name: 'Powerbank Belkin',
                price_html: 'EUR 18.99',
                image: productsPath + 'Producto7.jpg',
                permalink: 'product.html'
            },
            {
                id: 3,
                name: 'Tabla de Flexiones Portatil',
                price_html: 'EUR 22.99',
                image: productsPath + 'Producto5.jpg',
                permalink: 'product.html'
            }
        ]
    };

    function formatEuro(amount) {
        return 'EUR ' + amount.toFixed(2);
    }

    function payload() {
        var subtotal = state.items.reduce(function (sum, item) {
            return sum + item.unit * item.quantity;
        }, 0);
        var count = state.items.reduce(function (sum, item) {
            return sum + item.quantity;
        }, 0);

        return {
            items: state.items.map(function (item) {
                return {
                    key: item.key,
                    product_id: item.product_id,
                    name: item.name,
                    quantity: item.quantity,
                    price_html: formatEuro(item.unit * item.quantity),
                    image: item.image,
                    permalink: item.permalink,
                    max_qty: item.max_qty
                };
            }),
            count: count,
            subtotal_html: formatEuro(subtotal),
            checkout_url: '#',
            recommendations: state.recommendations,
            empty_message: 'Tu carrito esta vacio.'
        };
    }

    window.doroshoppingPreviewCart = {
        handle: function (action, data) {
            if (action === 'doroshopping_update_cart_item') {
                var qtyItem = state.items.find(function (item) { return item.key === data.key; });
                if (qtyItem) {
                    var next = parseInt(data.quantity, 10);
                    if (next < 1) {
                        state.items = state.items.filter(function (item) { return item.key !== data.key; });
                    } else {
                        qtyItem.quantity = next;
                    }
                }
            }

            if (action === 'doroshopping_remove_cart_item') {
                state.items = state.items.filter(function (item) { return item.key !== data.key; });
            }

            if (action === 'doroshopping_add_to_cart' && data && data.product) {
                var existing = state.items.find(function (item) { return String(item.product_id) === String(data.product.id); });
                if (existing) {
                    existing.quantity += parseInt(data.quantity, 10) || 1;
                } else {
                    state.items.push({
                        key: 'item-' + Date.now(),
                        product_id: data.product.id || Date.now(),
                        name: data.product.name || 'Producto',
                        quantity: parseInt(data.quantity, 10) || 1,
                        unit: data.product.unit || 0,
                        image: data.product.image || productsPath + 'Producto1.jpg',
                        permalink: data.product.permalink || 'product.html',
                        max_qty: 99
                    });
                }
            }

            return payload();
        }
    };

    window.doroshoppingPreviewSearch = function (term) {
        var q = String(term || '').toLowerCase();
        var productsPath = '../theme/Doro_theme_oficial/assets/images/products/';
        var matched = previewProducts.filter(function (p) {
            return p.name.toLowerCase().indexOf(q) !== -1;
        }).slice(0, 8).map(function (p, i) {
            return {
                id: i + 1,
                title: p.name,
                url: 'product.html',
                price_html: 'EUR ' + p.price,
                image: productsPath + p.image,
                sku: 'DORO-' + (100 + i)
            };
        });

        return {
            items: matched,
            total: matched.length,
            search_url: 'shop.html?s=' + encodeURIComponent(term)
        };
    };
})();
