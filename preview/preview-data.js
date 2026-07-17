var previewProducts = [
    { price: '23.99', name: 'Auriculares Bluetooth TWS Pro', image: 'Producto1.jpg' },
    { price: '45.50', name: 'Monitor LED 24 pulgadas Full HD', image: 'Producto2.png' },
    { price: '12.99', name: 'Cable USB-C rapido carga 2m', image: 'Producto3.jpg' },
    { price: '89.00', name: 'Teclado mecanico RGB Gaming', image: 'Producto4.jpg' },
    { price: '34.75', name: 'Raton inalambrico ergonomico', image: 'Producto5.jpg' },
    { price: '156.00', name: 'Tablet 10 pulgadas 64GB', image: 'Producto6.jpg' },
    { price: '28.50', name: 'Altavoz portatil resistente agua', image: 'Producto7.jpg' },
    { price: '67.99', name: 'Smartwatch deportivo GPS', image: 'Producto8.jpg' },
    { price: '19.99', name: 'Funda protectora smartphone', image: 'Producto1.jpg' },
    { price: '299.00', name: 'Portatil 15.6 8GB RAM SSD', image: 'Producto2.png' },
    { price: '8.50', name: 'Soporte movil para coche', image: 'Producto3.jpg' },
    { price: '42.00', name: 'Camara de seguridad WiFi', image: 'Producto4.jpg' },
    { price: '55.25', name: 'Impresora etiquetas termica', image: 'Producto5.jpg' },
    { price: '14.99', name: 'Lampara LED escritorio USB', image: 'Producto6.jpg' },
    { price: '78.00', name: 'Aspiradora robot compacta', image: 'Producto7.jpg' },
    { price: '31.50', name: 'Microfono condensador USB', image: 'Producto8.jpg' },
    { price: '22.00', name: 'Hub USB 7 puertos', image: 'Producto1.jpg' },
    { price: '95.99', name: 'Router WiFi 6 doble banda', image: 'Producto2.png' },
    { price: '18.75', name: 'Organizador cables escritorio', image: 'Producto3.jpg' },
    { price: '49.00', name: 'Mochila antirrobo portatil', image: 'Producto4.jpg' },
    { price: '37.50', name: 'Ventilador de pie silencioso', image: 'Producto5.jpg' },
    { price: '63.00', name: 'Proyector mini HD portatil', image: 'Producto6.jpg' },
    { price: '11.99', name: 'Protector pantalla cristal templado', image: 'Producto7.jpg' },
    { price: '72.50', name: 'Auriculares gaming 7.1 surround', image: 'Producto8.jpg' }
];

(function () {
    var grid = document.getElementById('products-grid');
    if (!grid) return;

    var cartSvg = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>';
    var productsPath = '../theme/doroshopping/assets/images/products/';

    previewProducts.forEach(function (product) {
        var card = document.createElement('article');
        card.className = 'home-product-card';
        card.innerHTML =
            '<a href="#" class="home-product-card__image-wrap">' +
                '<img src="' + productsPath + product.image + '" alt="' + product.name + '">' +
                '<button type="button" class="home-product-card__cart-btn" aria-label="Anadir al carrito">' + cartSvg + '</button>' +
            '</a>' +
            '<div class="home-product-card__info">' +
                '<p class="home-product-card__price">' + product.price + ' EUR</p>' +
                '<h3 class="home-product-card__name">' + product.name + '</h3>' +
            '</div>';
        grid.appendChild(card);
    });
})();
