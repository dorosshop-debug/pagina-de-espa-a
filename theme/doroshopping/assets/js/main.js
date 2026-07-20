function doroshoppingBoot() {
    initMegaMenu();
    initHeaderDropdowns();
    initHeroCarousel();
    initCategoryCarousels();
    initPromoParallax();
    initCartModal();
    initLiveSearch();
    initAjaxAddToCart();
    initProductVariationsLayout();
}

function doroshoppingStart() {
    if (document.querySelector('[data-include]')) {
        document.addEventListener('doroshopping:partials-loaded', doroshoppingBoot, { once: true });
        return;
    }
    doroshoppingBoot();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', doroshoppingStart);
} else {
    doroshoppingStart();
}

function initHeaderDropdowns() {
    var wraps = Array.prototype.slice.call(document.querySelectorAll('.site-header__dropdown-wrap'));
    if (!wraps.length) return;

    function closeAll() {
        wraps.forEach(function (wrap) {
            var btn = wrap.querySelector('.site-header__utility-btn');
            var panel = wrap.querySelector('.header-dropdown');
            wrap.classList.remove('is-open');
            if (btn) btn.setAttribute('aria-expanded', 'false');
            if (panel) panel.hidden = true;
        });
    }

    wraps.forEach(function (wrap) {
        var btn = wrap.querySelector('.site-header__utility-btn');
        var panel = wrap.querySelector('.header-dropdown');
        if (!btn || !panel) return;

        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            var isOpen = wrap.classList.contains('is-open');
            closeAll();
            if (!isOpen) {
                wrap.classList.add('is-open');
                btn.setAttribute('aria-expanded', 'true');
                panel.hidden = false;
            }
        });

        panel.addEventListener('click', function (e) {
            e.stopPropagation();
        });
    });

    document.addEventListener('click', closeAll);

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeAll();
    });
}

function initMegaMenu() {
    var categoriesBtn = document.querySelector('.site-nav__categories-btn');
    var categoriesWrap = document.querySelector('.site-nav__categories');
    var megaMenu = document.getElementById('mega-menu');

    function openMegaMenu() {
        if (!categoriesWrap || !megaMenu || !categoriesBtn) return;
        categoriesWrap.classList.add('is-open');
        megaMenu.hidden = false;
        categoriesBtn.setAttribute('aria-expanded', 'true');
    }

    function closeMegaMenu() {
        if (!categoriesWrap || !megaMenu || !categoriesBtn) return;
        categoriesWrap.classList.remove('is-open');
        megaMenu.hidden = true;
        categoriesBtn.setAttribute('aria-expanded', 'false');
    }

    if (categoriesBtn && categoriesWrap && megaMenu) {
        categoriesBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            if (categoriesWrap.classList.contains('is-open')) {
                closeMegaMenu();
            } else {
                openMegaMenu();
            }
        });

        document.addEventListener('click', function (e) {
            if (!categoriesWrap.contains(e.target)) {
                closeMegaMenu();
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeMegaMenu();
            }
        });
    }

    var catButtons = document.querySelectorAll('.mega-menu__cat');
    var panels = document.querySelectorAll('.mega-menu__panel');

    catButtons.forEach(function (btn) {
        btn.addEventListener('mouseenter', function () {
            activatePanel(btn.getAttribute('data-panel'), btn);
        });

        btn.addEventListener('click', function (e) {
            e.preventDefault();
            activatePanel(btn.getAttribute('data-panel'), btn);
        });
    });

    function activatePanel(panelId, activeBtn) {
        catButtons.forEach(function (b) {
            b.classList.remove('is-active');
            b.setAttribute('aria-selected', 'false');
        });
        if (activeBtn) {
            activeBtn.classList.add('is-active');
            activeBtn.setAttribute('aria-selected', 'true');
        }

        panels.forEach(function (panel) {
            var match = panel.getAttribute('data-panel') === panelId;
            panel.classList.toggle('is-active', match);
            panel.hidden = !match;
        });
    }
}

function initHeroCarousel() {
    var hero = document.querySelector('.home-hero');
    if (!hero) return;

    var slides = Array.prototype.slice.call(hero.querySelectorAll('.home-hero__slide'));
    var dots = Array.prototype.slice.call(hero.querySelectorAll('.home-hero__dot'));
    var prevBtn = hero.querySelector('.home-hero__nav--prev');
    var nextBtn = hero.querySelector('.home-hero__nav--next');
    var current = 0;
    var timer = null;
    var intervalMs = 5000;

    if (slides.length < 2) return;

    function goTo(index) {
        current = (index + slides.length) % slides.length;

        slides.forEach(function (slide, i) {
            var active = i === current;
            slide.classList.toggle('is-active', active);
            slide.hidden = !active;
        });

        dots.forEach(function (dot, i) {
            dot.classList.toggle('is-active', i === current);
        });
    }

    function next() {
        goTo(current + 1);
    }

    function prev() {
        goTo(current - 1);
    }

    function startAuto() {
        stopAuto();
        timer = setInterval(next, intervalMs);
    }

    function stopAuto() {
        if (timer) {
            clearInterval(timer);
            timer = null;
        }
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', function () {
            next();
            startAuto();
        });
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', function () {
            prev();
            startAuto();
        });
    }

    dots.forEach(function (dot) {
        dot.addEventListener('click', function () {
            goTo(parseInt(dot.getAttribute('data-slide'), 10));
            startAuto();
        });
    });

    hero.addEventListener('mouseenter', stopAuto);
    hero.addEventListener('mouseleave', startAuto);

    startAuto();
}

function initCategoryCarousels() {
    var blocks = document.querySelectorAll('.home-categories__col');
    var visible = 3;
    var intervalMs = 4000;

    blocks.forEach(function (block) {
        var wrap = block.querySelector('.home-categories__carousel-wrap');
        var track = block.querySelector('.home-categories__carousel-track');
        var products = block.querySelectorAll('.home-categories__product');
        var dotsWrap = block.querySelector('[data-dots]');
        var prevBtn = block.querySelector('.home-categories__arrow--prev');
        var nextBtn = block.querySelector('.home-categories__arrow--next');

        if (!track || products.length === 0) return;

        var pageCount = Math.max(1, Math.ceil(products.length / visible));
        var current = 0;
        var timer = null;

        if (dotsWrap) {
            dotsWrap.innerHTML = '';
            for (var i = 0; i < pageCount; i++) {
                var dot = document.createElement('button');
                dot.type = 'button';
                dot.className = 'home-categories__dot' + (i === 0 ? ' is-active' : '');
                dot.setAttribute('data-page', String(i));
                dot.setAttribute('aria-label', 'Pagina ' + (i + 1));
                dotsWrap.appendChild(dot);
            }
        }

        var dots = block.querySelectorAll('.home-categories__dot');

        function goTo(page) {
            current = (page + pageCount) % pageCount;
            var offset = current * visible;
            var productWidth = products[0].getBoundingClientRect().width;
            var gap = 8;
            var shift = offset * (productWidth + gap);
            track.style.transform = 'translateX(-' + shift + 'px)';

            dots.forEach(function (dot, i) {
                dot.classList.toggle('is-active', i === current);
            });
        }

        function next() {
            goTo(current + 1);
        }

        function prev() {
            goTo(current - 1);
        }

        function startAuto() {
            stopAuto();
            if (pageCount < 2) return;
            timer = setInterval(next, intervalMs);
        }

        function stopAuto() {
            if (timer) {
                clearInterval(timer);
                timer = null;
            }
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', function () {
                prev();
                startAuto();
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', function () {
                next();
                startAuto();
            });
        }

        dots.forEach(function (dot) {
            dot.addEventListener('click', function () {
                goTo(parseInt(dot.getAttribute('data-page'), 10));
                startAuto();
            });
        });

        if (wrap) {
            wrap.addEventListener('mouseenter', stopAuto);
            wrap.addEventListener('mouseleave', startAuto);
        }

        window.addEventListener('resize', function () {
            goTo(current);
        });

        startAuto();
    });
}

function initPromoParallax() {
    var promo = document.querySelector('[data-promo-parallax]');
    if (!promo) return;

    var floats = Array.prototype.slice.call(promo.querySelectorAll('.home-promo__float'));
    if (!floats.length) return;

    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduceMotion) return;

    var bounds = null;
    var rafId = null;
    var targetX = 0;
    var targetY = 0;
    var currentX = 0;
    var currentY = 0;

    function updateBounds() {
        bounds = promo.getBoundingClientRect();
    }

    function onMove(e) {
        if (!bounds) updateBounds();
        var x = (e.clientX - bounds.left) / bounds.width - 0.5;
        var y = (e.clientY - bounds.top) / bounds.height - 0.5;
        targetX = x;
        targetY = y;
        if (!rafId) rafId = requestAnimationFrame(render);
    }

    function render() {
        currentX += (targetX - currentX) * 0.08;
        currentY += (targetY - currentY) * 0.08;

        floats.forEach(function (el, index) {
            var depth = index === 0 ? 18 : 28;
            var tx = currentX * depth;
            var ty = currentY * depth;
            el.style.transform = 'translate3d(' + tx + 'px, ' + ty + 'px, 0)';
        });

        if (Math.abs(targetX - currentX) > 0.001 || Math.abs(targetY - currentY) > 0.001) {
            rafId = requestAnimationFrame(render);
        } else {
            rafId = null;
        }
    }

    function onLeave() {
        targetX = 0;
        targetY = 0;
        if (!rafId) rafId = requestAnimationFrame(render);
    }

    updateBounds();
    promo.addEventListener('mousemove', onMove);
    promo.addEventListener('mouseleave', onLeave);
    window.addEventListener('resize', updateBounds);
}

function initCartModal() {
    var modal = document.getElementById('cart-modal');
    var fab = document.getElementById('site-fab-cart');
    if (!modal || !fab) return;

    var itemsEl = modal.querySelector('[data-cart-items]');
    var subtotalEl = modal.querySelector('[data-cart-subtotal]');
    var recsEl = modal.querySelector('[data-cart-recs]');
    var checkoutEl = modal.querySelector('[data-cart-checkout]');
    var countEls = document.querySelectorAll('[data-cart-count], .site-header__cart-count');
    var cfg = window.doroshoppingCart || {};
    var previewMode = !!window.doroshoppingPreviewCart;
    var loading = false;

    function i18n(key, fallback) {
        return (cfg.i18n && cfg.i18n[key]) || fallback;
    }

    function escapeHtml(str) {
        return String(str == null ? '' : str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }

    function openModal() {
        modal.hidden = false;
        modal.setAttribute('aria-hidden', 'false');
        fab.setAttribute('aria-expanded', 'true');
        document.body.classList.add('cart-modal-open');
        var dialog = modal.querySelector('.cart-modal__dialog');
        if (dialog) dialog.focus();
        refreshCart();
    }

    function closeModal() {
        modal.hidden = true;
        modal.setAttribute('aria-hidden', 'true');
        fab.setAttribute('aria-expanded', 'false');
        document.body.classList.remove('cart-modal-open');
    }

    function updateCounts(count) {
        countEls.forEach(function (el) {
            el.textContent = String(count || 0);
        });
    }

    function trashSvg() {
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/></svg>';
    }

    function renderItems(data) {
        var items = data.items || [];
        updateCounts(data.count || 0);

        if (subtotalEl) {
            subtotalEl.innerHTML = data.subtotal_html || '—';
        }

        if (checkoutEl) {
            if (data.checkout_url) checkoutEl.setAttribute('href', data.checkout_url);
            checkoutEl.classList.toggle('is-disabled', items.length === 0);
        }

        if (!itemsEl) return;

        if (!items.length) {
            itemsEl.innerHTML = '<p class="cart-modal__empty">' + (data.empty_message || i18n('empty', 'Tu carrito esta vacio.')) + '</p>';
        } else {
            itemsEl.innerHTML = items.map(function (item) {
                return (
                    '<article class="cart-modal__item" data-cart-key="' + escapeHtml(item.key) + '">' +
                        '<a class="cart-modal__item-image" href="' + escapeHtml(item.permalink || '#') + '">' +
                            '<img src="' + escapeHtml(item.image) + '" alt="">' +
                        '</a>' +
                        '<div class="cart-modal__item-main">' +
                            '<div class="cart-modal__item-top">' +
                                '<h3 class="cart-modal__item-name">' + escapeHtml(item.name) + '</h3>' +
                                '<button type="button" class="cart-modal__item-remove" data-cart-remove="' + escapeHtml(item.key) + '" aria-label="' + escapeHtml(i18n('remove', 'Eliminar producto')) + '">' + trashSvg() + '</button>' +
                            '</div>' +
                            '<div class="cart-modal__item-bottom">' +
                                '<div class="cart-modal__qty">' +
                                    '<button type="button" class="cart-modal__qty-btn" data-cart-qty="' + escapeHtml(item.key) + '" data-delta="-1" aria-label="' + escapeHtml(i18n('decrease', 'Reducir cantidad')) + '">−</button>' +
                                    '<span class="cart-modal__qty-value">' + escapeHtml(item.quantity) + '</span>' +
                                    '<button type="button" class="cart-modal__qty-btn" data-cart-qty="' + escapeHtml(item.key) + '" data-delta="1" aria-label="' + escapeHtml(i18n('increase', 'Aumentar cantidad')) + '">+</button>' +
                                '</div>' +
                                '<p class="cart-modal__item-price">' + (item.price_html || '') + '</p>' +
                            '</div>' +
                        '</div>' +
                    '</article>'
                );
            }).join('');
        }

        if (recsEl) {
            var recs = data.recommendations || [];
            if (!recs.length) {
                recsEl.innerHTML = '';
            } else {
                recsEl.innerHTML = recs.map(function (rec) {
                    return (
                        '<a class="cart-modal__rec" href="' + escapeHtml(rec.permalink || '#') + '">' +
                            '<div class="cart-modal__rec-image"><img src="' + escapeHtml(rec.image) + '" alt=""></div>' +
                            '<div>' +
                                '<p class="cart-modal__rec-name">' + escapeHtml(rec.name) + '</p>' +
                                '<p class="cart-modal__rec-price">' + (rec.price_html || '') + '</p>' +
                            '</div>' +
                        '</a>'
                    );
                }).join('');
            }
        }
    }

    function request(action, payload) {
        if (previewMode && window.doroshoppingPreviewCart) {
            return Promise.resolve(window.doroshoppingPreviewCart.handle(action, payload));
        }

        if (!cfg.ajaxUrl || !cfg.nonce) {
            return Promise.reject(new Error('Cart config missing'));
        }

        var body = new FormData();
        body.append('action', action);
        body.append('nonce', cfg.nonce);
        Object.keys(payload || {}).forEach(function (key) {
            body.append(key, payload[key]);
        });

        return fetch(cfg.ajaxUrl, {
            method: 'POST',
            credentials: 'same-origin',
            body: body
        }).then(function (res) {
            return res.json();
        }).then(function (json) {
            if (!json || !json.success) {
                throw new Error((json && json.data && json.data.message) || 'Cart error');
            }
            return json.data;
        });
    }

    function refreshCart() {
        if (loading) return;
        loading = true;
        request('doroshopping_get_cart', {})
            .then(renderItems)
            .catch(function () { /* silent */ })
            .finally(function () { loading = false; });
    }

    function changeQty(key, delta) {
        var row = itemsEl && itemsEl.querySelector('[data-cart-key="' + key + '"]');
        var current = 1;
        if (row) {
            var val = row.querySelector('.cart-modal__qty-value');
            current = val ? parseInt(val.textContent, 10) || 1 : 1;
        }
        var next = Math.max(0, current + delta);
        loading = true;
        request('doroshopping_update_cart_item', { key: key, quantity: next })
            .then(renderItems)
            .catch(function () { /* silent */ })
            .finally(function () { loading = false; });
    }

    function removeItem(key) {
        loading = true;
        request('doroshopping_remove_cart_item', { key: key })
            .then(renderItems)
            .catch(function () { /* silent */ })
            .finally(function () { loading = false; });
    }

    fab.addEventListener('click', function (e) {
        e.preventDefault();
        openModal();
    });

    modal.querySelectorAll('[data-cart-close]').forEach(function (el) {
        el.addEventListener('click', closeModal);
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !modal.hidden) closeModal();
    });

    if (itemsEl) {
        itemsEl.addEventListener('click', function (e) {
            var removeBtn = e.target.closest('[data-cart-remove]');
            if (removeBtn) {
                e.preventDefault();
                removeItem(removeBtn.getAttribute('data-cart-remove'));
                return;
            }
            var qtyBtn = e.target.closest('[data-cart-qty]');
            if (qtyBtn) {
                e.preventDefault();
                changeQty(qtyBtn.getAttribute('data-cart-qty'), parseInt(qtyBtn.getAttribute('data-delta'), 10));
            }
        });
    }

    document.body.addEventListener('added_to_cart', function () {
        refreshCart();
    });

    document.body.addEventListener('removed_from_cart', function () {
        refreshCart();
    });

    if (typeof cfg.initialCount !== 'undefined') {
        updateCounts(cfg.initialCount);
    }
}

function initLiveSearch() {
    var wraps = Array.prototype.slice.call(document.querySelectorAll('[data-live-search]'));
    if (!wraps.length) return;

    var cfg = window.doroshoppingSearch || {};
    var minChars = cfg.minChars || 2;
    var previewMode = !!window.doroshoppingPreviewSearch;

    wraps.forEach(function (wrap) {
        var input = wrap.querySelector('[data-live-search-input]');
        var panel = wrap.querySelector('[data-live-search-panel]');
        var list = wrap.querySelector('[data-live-search-results]');
        var emptyEl = wrap.querySelector('[data-live-search-empty]');
        var loadingEl = wrap.querySelector('[data-live-search-loading]');
        var allLink = wrap.querySelector('[data-live-search-all]');
        var form = wrap.querySelector('form');
        var timer = null;
        var controller = null;

        if (!input || !panel || !list) return;

        function escapeHtml(str) {
            return String(str == null ? '' : str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
        }

        function openPanel() {
            panel.hidden = false;
            input.setAttribute('aria-expanded', 'true');
        }

        function closePanel() {
            panel.hidden = true;
            input.setAttribute('aria-expanded', 'false');
        }

        function setLoading(on) {
            if (loadingEl) loadingEl.hidden = !on;
            if (emptyEl) emptyEl.hidden = true;
            if (allLink) allLink.hidden = true;
            if (on) list.innerHTML = '';
        }

        function render(data, term) {
            var items = (data && data.items) || [];
            list.innerHTML = '';

            if (!items.length) {
                if (emptyEl) emptyEl.hidden = false;
                if (allLink) allLink.hidden = true;
                openPanel();
                return;
            }

            if (emptyEl) emptyEl.hidden = true;
            items.forEach(function (item) {
                var li = document.createElement('li');
                li.className = 'live-search__item';
                li.innerHTML =
                    '<a class="live-search__link" href="' + escapeHtml(item.url) + '" role="option">' +
                        '<div class="live-search__thumb">' +
                            (item.image ? '<img src="' + escapeHtml(item.image) + '" alt="">' : '') +
                        '</div>' +
                        '<div>' +
                            '<p class="live-search__title">' + escapeHtml(item.title) + '</p>' +
                            (item.sku ? '<p class="live-search__sku">SKU: ' + escapeHtml(item.sku) + '</p>' : '') +
                        '</div>' +
                        '<p class="live-search__price">' + (item.price_html || '') + '</p>' +
                    '</a>';
                list.appendChild(li);
            });

            if (allLink) {
                allLink.hidden = false;
                allLink.href = data.search_url || ((form && form.action ? form.action : '/') + '?s=' + encodeURIComponent(term) + '&post_type=product');
                allLink.textContent = (cfg.i18n && cfg.i18n.viewAll) || 'Ver todos los resultados';
            }
            openPanel();
        }

        function search(term) {
            if (previewMode && window.doroshoppingPreviewSearch) {
                render(window.doroshoppingPreviewSearch(term), term);
                return;
            }

            if (!cfg.ajaxUrl || !cfg.nonce) return;

            if (controller && controller.abort) controller.abort();
            controller = typeof AbortController !== 'undefined' ? new AbortController() : null;

            setLoading(true);
            openPanel();

            var url = cfg.ajaxUrl +
                '?action=doroshopping_live_search' +
                '&nonce=' + encodeURIComponent(cfg.nonce) +
                '&term=' + encodeURIComponent(term);

            fetch(url, {
                method: 'GET',
                credentials: 'same-origin',
                signal: controller ? controller.signal : undefined
            })
                .then(function (res) { return res.json(); })
                .then(function (json) {
                    setLoading(false);
                    if (json && json.success) {
                        render(json.data, term);
                    }
                })
                .catch(function (err) {
                    if (err && err.name === 'AbortError') return;
                    setLoading(false);
                });
        }

        input.addEventListener('input', function () {
            var term = input.value.trim();
            clearTimeout(timer);
            if (term.length < minChars) {
                closePanel();
                list.innerHTML = '';
                return;
            }
            timer = setTimeout(function () {
                search(term);
            }, 280);
        });

        input.addEventListener('focus', function () {
            if (input.value.trim().length >= minChars && list.children.length) {
                openPanel();
            }
        });

        document.addEventListener('click', function (e) {
            if (!wrap.contains(e.target)) closePanel();
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closePanel();
        });
    });
}

/**
 * Add to cart AJAX desde cards de home / botones .ajax_add_to_cart del tema.
 */
function initAjaxAddToCart() {
    var cfg = window.doroshoppingCart || {};

    document.addEventListener('click', function (e) {
        var btn = e.target.closest('.home-product-card__cart-btn.ajax_add_to_cart, .home-product-card__cart-btn.add_to_cart_button');
        if (!btn || btn.tagName === 'A') return;

        e.preventDefault();
        e.stopPropagation();

        if (btn.classList.contains('loading')) return;

        var productId = btn.getAttribute('data-product_id');
        if (!productId) return;

        var quantity = btn.getAttribute('data-quantity') || '1';
        btn.classList.add('loading');
        btn.setAttribute('aria-busy', 'true');

        function done(ok) {
            btn.classList.remove('loading');
            btn.removeAttribute('aria-busy');
            if (ok) {
                btn.classList.add('added');
                setTimeout(function () { btn.classList.remove('added'); }, 1800);
                document.body.dispatchEvent(new CustomEvent('added_to_cart', { detail: { product_id: productId } }));
                if (typeof jQuery !== 'undefined') {
                    jQuery(document.body).trigger('added_to_cart', [{}, '', jQuery(btn)]);
                }
            } else if (cfg.i18n && cfg.i18n.error) {
                btn.setAttribute('title', cfg.i18n.error);
            }
        }

        // Preview estático
        if (window.doroshoppingPreviewCart && typeof window.doroshoppingPreviewCart.add === 'function') {
            window.doroshoppingPreviewCart.add(productId, quantity);
            done(true);
            return;
        }

        var endpoint = cfg.wcAjaxUrl
            ? String(cfg.wcAjaxUrl).replace('%%endpoint%%', 'add_to_cart')
            : '';

        if (!endpoint) {
            // Fallback admin-ajax WC
            endpoint = (cfg.ajaxUrl || '/wp-admin/admin-ajax.php') + '?action=woocommerce_add_to_cart';
        }

        var body = new FormData();
        body.append('product_id', productId);
        body.append('quantity', quantity);

        fetch(endpoint, {
            method: 'POST',
            credentials: 'same-origin',
            body: body
        })
            .then(function (res) { return res.json(); })
            .then(function (data) {
                if (data && (data.error || data.success === false)) {
                    done(false);
                    if (data.product_url) window.location = data.product_url;
                    return;
                }
                // Actualizar fragments WC si vienen
                if (data && data.fragments && typeof jQuery !== 'undefined') {
                    jQuery.each(data.fragments, function (key, value) {
                        jQuery(key).replaceWith(value);
                    });
                    jQuery(document.body).trigger('wc_fragments_refreshed');
                }
                done(true);
            })
            .catch(function () { done(false); });
    });
}

/**
 * Variaciones en columna central (UI espejo; form WC real en buy box).
 */
function initProductVariationsLayout() {
    var form = document.querySelector('.doro-buybox form.variations_form');
    var summary = document.querySelector('.doro-product__summary');
    if (!form || !summary) return;

    var table = form.querySelector('table.variations');
    if (!table || summary.querySelector('.doro-product__variations')) return;

    var mirror = table.cloneNode(true);
    mirror.classList.add('doro-product__variations-table');
    mirror.removeAttribute('id');
    mirror.querySelectorAll('[id]').forEach(function (el) {
        el.id = el.id + '-mirror';
    });
    mirror.querySelectorAll('label[for]').forEach(function (lab) {
        var f = lab.getAttribute('for');
        if (f) lab.setAttribute('for', f + '-mirror');
    });
    mirror.querySelectorAll('select').forEach(function (sel) {
        sel.removeAttribute('name');
    });

    var wrap = document.createElement('div');
    wrap.className = 'doro-product__variations';
    wrap.appendChild(mirror);
    summary.appendChild(wrap);

    table.classList.add('doro-product__variations-source');
    table.setAttribute('aria-hidden', 'true');

    var sourceSelects = form.querySelectorAll('table.variations select');
    var mirrorSelects = mirror.querySelectorAll('select');

    mirrorSelects.forEach(function (mirrorSelect, idx) {
        mirrorSelect.addEventListener('change', function () {
            var source = sourceSelects[idx];
            if (!source) return;
            source.value = mirrorSelect.value;
            if (window.jQuery) {
                window.jQuery(source).trigger('change');
            } else {
                source.dispatchEvent(new Event('change', { bubbles: true }));
            }
        });
    });

    sourceSelects.forEach(function (sourceSelect, idx) {
        sourceSelect.addEventListener('change', function () {
            var m = mirrorSelects[idx];
            if (m && m.value !== sourceSelect.value) {
                m.value = sourceSelect.value;
            }
        });
    });
}
