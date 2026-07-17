var previewProducts = [
    { price: '23.99', name: 'Auriculares Bluetooth TWS Pro' },
    { price: '45.50', name: 'Monitor LED 24 pulgadas Full HD' },
    { price: '12.99', name: 'Cable USB-C rapido carga 2m' },
    { price: '89.00', name: 'Teclado mecanico RGB Gaming' },
    { price: '34.75', name: 'Raton inalambrico ergonomico' },
    { price: '156.00', name: 'Tablet 10 pulgadas 64GB' },
    { price: '28.50', name: 'Altavoz portatil resistente agua' },
    { price: '67.99', name: 'Smartwatch deportivo GPS' },
    { price: '19.99', name: 'Funda protectora smartphone' },
    { price: '299.00', name: 'Portatil 15.6 8GB RAM SSD' },
    { price: '8.50', name: 'Soporte movil para coche' },
    { price: '42.00', name: 'Camara de seguridad WiFi' },
    { price: '55.25', name: 'Impresora etiquetas termica' },
    { price: '14.99', name: 'Lampara LED escritorio USB' },
    { price: '78.00', name: 'Aspiradora robot compacta' },
    { price: '31.50', name: 'Microfono condensador USB' },
    { price: '22.00', name: 'Hub USB 7 puertos' },
    { price: '95.99', name: 'Router WiFi 6 doble banda' },
    { price: '18.75', name: 'Organizador cables escritorio' },
    { price: '49.00', name: 'Mochila antirrobo portatil' },
    { price: '37.50', name: 'Ventilador de pie silencioso' },
    { price: '63.00', name: 'Proyector mini HD portatil' },
    { price: '11.99', name: 'Protector pantalla cristal templado' },
    { price: '72.50', name: 'Auriculares gaming 7.1 surround' }
];

(function () {
    var grid = document.getElementById('products-grid');
    if (!grid) return;

    var cartSvg = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>';

    previewProducts.forEach(function (product, index) {
        var card = document.createElement('article');
        card.className = 'home-product-card';
        card.innerHTML =
            '<a href="#" class="home-product-card__image-wrap">' +
                '<img src="../theme/doroshopping/assets/images/icon.png" alt="' + product.name + '">' +
                '<button type="button" class="home-product-card__cart-btn" aria-label="Anadir al carrito">' + cartSvg + '</button>' +
            '</a>' +
            '<div class="home-product-card__info">' +
                '<p class="home-product-card__price">' + product.price + ' EUR</p>' +
                '<h3 class="home-product-card__name">' + product.name + '</h3>' +
            '</div>';
        grid.appendChild(card);
    });
})();
