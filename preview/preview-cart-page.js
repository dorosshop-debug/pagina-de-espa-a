/**
 * Renderiza la pagina cart.html desde el carrito preview (localStorage).
 */
(function () {
    function esc(str) {
        return String(str == null ? '' : str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    function render() {
        if (!window.doroshoppingPreviewCart || typeof window.doroshoppingPreviewCart.handle !== 'function') {
            return;
        }

        var data = window.doroshoppingPreviewCart.handle('doroshopping_get_cart', {});
        var main = document.querySelector('.doro-cesta__main');
        var totalEl = document.querySelector('.doro-cesta-summary__total');
        var cta = document.querySelector('.doro-cesta-summary__cta');
        if (!main) return;

        var items = data.items || [];
        var count = data.count || 0;

        if (totalEl) {
            totalEl.textContent = (data.subtotal_html || 'EUR 0.00').replace('EUR ', '') + ' EUR';
        }

        if (cta) {
            if (count > 0) {
                cta.classList.remove('is-disabled');
                cta.removeAttribute('aria-disabled');
                cta.setAttribute('href', 'checkout.html');
                cta.textContent = 'Continuar (' + count + ')';
            } else {
                cta.classList.add('is-disabled');
                cta.setAttribute('aria-disabled', 'true');
                cta.setAttribute('href', 'shop.html');
                cta.textContent = 'Continuar (0)';
            }
        }

        if (!items.length) {
            main.innerHTML =
                '<h1 class="doro-cesta__title">Cesta</h1>' +
                '<div class="doro-cesta-empty">' +
                    '<img class="doro-cesta-empty__image" src="../theme/Doro_theme_oficial/assets/images/cart/carrito_doro.png" alt="" width="220" height="180">' +
                    '<p class="doro-cesta-empty__text">Tu carrito está vacío</p>' +
                    '<div class="doro-cesta-empty__actions">' +
                        '<a class="doro-cesta-empty__btn doro-cesta-empty__btn--primary" href="account.html">Identifícate</a>' +
                        '<a class="doro-cesta-empty__btn doro-cesta-empty__btn--dark" href="shop.html">Explora artículos</a>' +
                    '</div>' +
                '</div>';
            return;
        }

        var rows = items.map(function (item) {
            return (
                '<tr class="woocommerce-cart-form__cart-item cart_item" data-cart-key="' + esc(item.key) + '">' +
                    '<td class="product-remove">' +
                        '<button type="button" class="remove" data-preview-cart-remove="' + esc(item.key) + '" aria-label="Eliminar">×</button>' +
                    '</td>' +
                    '<td class="product-thumbnail"><a href="' + esc(item.permalink || 'product.html') + '"><img src="' + esc(item.image) + '" alt=""></a></td>' +
                    '<td class="product-name" data-title="Producto"><a href="' + esc(item.permalink || 'product.html') + '">' + esc(item.name) + '</a></td>' +
                    '<td class="product-price" data-title="Precio">' + (item.price_html || '') + '</td>' +
                    '<td class="product-quantity" data-title="Cantidad">' +
                        '<div class="quantity">' +
                            '<button type="button" data-preview-cart-qty="' + esc(item.key) + '" data-delta="-1" aria-label="Reducir">−</button>' +
                            '<span class="qty">' + esc(item.quantity) + '</span>' +
                            '<button type="button" data-preview-cart-qty="' + esc(item.key) + '" data-delta="1" aria-label="Aumentar">+</button>' +
                        '</div>' +
                    '</td>' +
                    '<td class="product-subtotal" data-title="Subtotal">' + (item.price_html || '') + '</td>' +
                '</tr>'
            );
        }).join('');

        main.innerHTML =
            '<h1 class="doro-cesta__title">Cesta</h1>' +
            '<form class="woocommerce-cart-form" action="#" method="post">' +
                '<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">' +
                    '<thead><tr>' +
                        '<th class="product-remove">&nbsp;</th>' +
                        '<th class="product-thumbnail">&nbsp;</th>' +
                        '<th class="product-name">Producto</th>' +
                        '<th class="product-price">Precio</th>' +
                        '<th class="product-quantity">Cantidad</th>' +
                        '<th class="product-subtotal">Subtotal</th>' +
                    '</tr></thead>' +
                    '<tbody>' + rows + '</tbody>' +
                '</table>' +
            '</form>';
    }

    function bind() {
        var main = document.querySelector('.doro-cesta__main');
        if (!main || main.getAttribute('data-preview-cart-bound')) return;
        main.setAttribute('data-preview-cart-bound', '1');

        main.addEventListener('click', function (e) {
            var removeBtn = e.target.closest('[data-preview-cart-remove]');
            if (removeBtn) {
                e.preventDefault();
                window.doroshoppingPreviewCart.handle('doroshopping_remove_cart_item', {
                    key: removeBtn.getAttribute('data-preview-cart-remove')
                });
                render();
                return;
            }

            var qtyBtn = e.target.closest('[data-preview-cart-qty]');
            if (qtyBtn) {
                e.preventDefault();
                var key = qtyBtn.getAttribute('data-preview-cart-qty');
                var delta = parseInt(qtyBtn.getAttribute('data-delta'), 10) || 0;
                var row = main.querySelector('[data-cart-key="' + key + '"] .qty');
                var current = row ? parseInt(row.textContent, 10) || 1 : 1;
                window.doroshoppingPreviewCart.handle('doroshopping_update_cart_item', {
                    key: key,
                    quantity: Math.max(0, current + delta)
                });
                render();
            }
        });
    }

    function boot() {
        render();
        bind();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }
})();
