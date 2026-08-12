function doroshoppingBoot() {
    initStickyHeader();
    initMegaMenu();
    initAuthModal();
    initHeaderDropdowns();
    initLocaleFlagOptions();
    initHeroCarousel();
    initCategoryCarousels();
    initRelatedProductsCarousel();
    initPromoParallax();
    initCartModal();
    initLiveSearch();
    initAjaxAddToCart();
    initProductBuybox();
    initProductVariationsLayout();
    initProductDescriptionClamp();
    initProductGalleryThumbs();
    initVisualSearchSlot();
    initWishlist();
    initAddressModal();
    initBigBuyShipping();
    initCheckoutHelpers();
    initCheckoutCountrySeed();
    hideTechnicalCheckoutNotices();
    initShopLoadMore();
    initShopCategoryFilter();
    initShopMobileFilters();
    initHomeLoadMore();
    initProductMoreLoadMore();
    initLegalPageToc();
    initProductShare();
    initSecurePaymentsModal();
    initCartPageEmptyReload();
    initGeoSuggestBanner();
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

function initStickyHeader() {
    var header = document.querySelector('.site-header');
    if (!header) return;

    function onScroll() {
        header.classList.toggle('is-scrolled', window.scrollY > 8);
    }

    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
}

function initAddressModal() {
    var modal = document.getElementById('doro-address-modal');
    if (!modal) return;

    var openers = document.querySelectorAll('[data-address-modal-open]');
    var closers = modal.querySelectorAll('[data-address-modal-close]');
    var confirmBtn = modal.querySelector('[data-address-modal-confirm]');
    var preview = document.querySelector('[data-address-preview]');
    var editBtn = document.querySelector('[data-address-mode="edit"]');
    var titleEl = modal.querySelector('.doro-modal__title');
    var bodyEl = modal.querySelector('.doro-modal__body');
    var requiredIds = [
        'billing_first_name',
        'billing_last_name',
        'billing_address_1',
        'billing_city',
        'billing_postcode',
        'billing_phone',
        'billing_email',
        'billing_country'
    ];

    function $jq() {
        return window.jQuery || null;
    }

    /**
     * Select2/SelectWoo en el modal se rompe (desplegable abajo / pa?ses en Departamento).
     * Usamos <select> nativo; country_to_state de WooCommerce sigue funcionando.
     */
    function useNativeSelects() {
        var $ = $jq();

        if ($ && $.fn) {
            var plugin = $.fn.selectWoo ? 'selectWoo' : ($.fn.select2 ? 'select2' : null);
            if (plugin) {
                $(modal).find('select').each(function () {
                    var $el = $(this);
                    if ($el.hasClass('select2-hidden-accessible') || $el.data(plugin) || $el.data('select2') || $el.data('selectWoo')) {
                        try {
                            $el[plugin]('destroy');
                        } catch (err) { /* ignore */ }
                    }
                    $el.removeClass('select2-hidden-accessible enhanced');
                    $el.css({ width: '100%', display: 'block', visibility: 'visible' });
                    $el.removeAttr('aria-hidden tabindex');
                });
            }
        }

        modal.querySelectorAll('.select2-container').forEach(function (el) {
            if (el.parentNode) el.parentNode.removeChild(el);
        });

        modal.querySelectorAll('select').forEach(function (sel) {
            sel.style.display = 'block';
            sel.style.visibility = 'visible';
            sel.style.width = '100%';
            sel.removeAttribute('aria-hidden');
        });
    }

    function syncShippingFromBilling() {
        var map = [
            ['billing_first_name', 'shipping_first_name'],
            ['billing_last_name', 'shipping_last_name'],
            ['billing_company', 'shipping_company'],
            ['billing_country', 'shipping_country'],
            ['billing_address_1', 'shipping_address_1'],
            ['billing_address_2', 'shipping_address_2'],
            ['billing_city', 'shipping_city'],
            ['billing_state', 'shipping_state'],
            ['billing_postcode', 'shipping_postcode']
        ];
        map.forEach(function (pair) {
            var from = document.getElementById(pair[0]);
            var to = document.getElementById(pair[1]);
            if (from && to) {
                to.value = from.value;
            }
        });
        var shipToDiff = document.getElementById('ship-to-different-address-checkbox');
        if (shipToDiff) {
            shipToDiff.checked = false;
        }
    }

    function openModal(mode) {
        modal.hidden = false;
        modal.removeAttribute('hidden');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('doro-modal-open');
        if (titleEl) {
            var shipI18n = (window.doroshoppingShipping && window.doroshoppingShipping.i18n) ? window.doroshoppingShipping.i18n : {};
            titleEl.textContent = mode === 'edit'
                ? (shipI18n.addressEdit || 'Editar dirección')
                : (shipI18n.addressAdd || 'Añadir nueva dirección');
        }
        clearFieldErrors();
        if (bodyEl) {
            bodyEl.scrollTop = 0;
        }
        useNativeSelects();
        setTimeout(function () {
            useNativeSelects();
            var first = modal.querySelector('#billing_first_name, input:not([type="hidden"]), select, textarea');
            if (first && typeof first.focus === 'function') {
                first.focus();
            }
        }, 50);
    }

    function closeModal() {
        var active = document.activeElement;
        if (active && modal.contains(active) && typeof active.blur === 'function') {
            active.blur();
        }
        document.querySelectorAll('body > .select2-container--open, body > .select2-dropdown').forEach(function (el) {
            if (el.parentNode) el.parentNode.removeChild(el);
        });
        modal.setAttribute('aria-hidden', 'true');
        modal.hidden = true;
        document.body.classList.remove('doro-modal-open');
    }

    function readField(id) {
        var el = document.getElementById(id) || modal.querySelector('[name="' + id + '"]');
        return el && el.value ? String(el.value).trim() : '';
    }

    function hasAddress() {
        return !!(readField('billing_first_name') || readField('billing_last_name')) && !!readField('billing_address_1');
    }

    function clearFieldErrors() {
        modal.querySelectorAll('.form-row.doro-field-error').forEach(function (row) {
            row.classList.remove('doro-field-error', 'woocommerce-invalid');
        });
        var banner = modal.querySelector('[data-address-error]');
        if (banner) banner.remove();
        if (bodyEl) bodyEl.classList.remove('is-invalid');
    }

    function showErrorBanner(message) {
        clearFieldErrors();
        if (!bodyEl) return;
        bodyEl.classList.add('is-invalid');
        var banner = document.createElement('p');
        banner.className = 'doro-modal__error';
        banner.setAttribute('data-address-error', '1');
        banner.textContent = message;
        bodyEl.insertBefore(banner, bodyEl.firstChild);
        bodyEl.scrollTop = 0;
    }

    function validateModalFields() {
        clearFieldErrors();
        var firstInvalid = null;

        requiredIds.forEach(function (id) {
            var el = document.getElementById(id) || modal.querySelector('[name="' + id + '"]');
            if (!el || el.disabled || el.type === 'hidden') return;
            var row = el.closest('.form-row');
            var value = el.value ? String(el.value).trim() : '';
            if (!value) {
                if (row) {
                    row.classList.add('doro-field-error', 'woocommerce-invalid');
                }
                if (!firstInvalid) firstInvalid = el;
            }
        });

        var state = document.getElementById('billing_state');
        if (state && !state.disabled) {
            var stateRow = state.closest('.form-row');
            var stateRequired = stateRow && stateRow.classList.contains('validate-required');
            var stateVal = state.value ? String(state.value).trim() : '';
            if (stateRequired && !stateVal) {
                if (stateRow) stateRow.classList.add('doro-field-error', 'woocommerce-invalid');
                if (!firstInvalid) firstInvalid = state;
            }
        }

        modal.querySelectorAll('.validate-required input, .validate-required select, .validate-required textarea, [required]').forEach(function (field) {
            if (field.disabled || field.type === 'hidden') return;
            var value = field.value ? String(field.value).trim() : '';
            if (!value) {
                var row = field.closest('.form-row');
                if (row) row.classList.add('doro-field-error', 'woocommerce-invalid');
                if (!firstInvalid) firstInvalid = field;
            }
        });

        if (firstInvalid) {
            showErrorBanner('Completa los campos obligatorios marcados en rojo.');
            if (typeof firstInvalid.focus === 'function') firstInvalid.focus();
            return false;
        }
        return true;
    }

    function triggerCheckoutUpdate() {
        var $ = $jq();
        if ($) {
            $(document.body).trigger('update_checkout');
        }
    }

    function syncEditButton() {
        if (!editBtn) return;
        editBtn.hidden = !hasAddress();
    }

    function updatePreview() {
        if (!preview) return;
        var name = (readField('billing_first_name') + ' ' + readField('billing_last_name')).trim();
        var address = readField('billing_address_1');
        var city = readField('billing_city');
        var postcode = readField('billing_postcode');
        var phone = readField('billing_phone');
        var country = readField('billing_country');
        var state = readField('billing_state');

        function esc(str) {
            return String(str || '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }

        if (!name && !address) {
            var emptyMsg = (window.doroshoppingShipping && window.doroshoppingShipping.i18n && window.doroshoppingShipping.i18n.emptyAddress)
                ? window.doroshoppingShipping.i18n.emptyAddress
                : 'Aún no has añadido una dirección de entrega.';
            preview.innerHTML = '<p class="doro-checkout-address__empty">' + esc(emptyMsg) + '</p>';
            syncEditButton();
            return;
        }
        preview.innerHTML =
            '<div class="doro-checkout-address__card">' +
                '<strong>' + esc(name || 'Direccion') + '</strong>' +
                (address ? '<span>' + esc(address) + '</span>' : '') +
                ((postcode || city) ? '<span>' + esc([postcode, city].filter(Boolean).join(' ')) + '</span>' : '') +
                ((state || country) ? '<span>' + esc([state, country].filter(Boolean).join(', ')) + '</span>' : '') +
                (phone ? '<span>' + esc(phone) + '</span>' : '') +
            '</div>';
        syncEditButton();
    }

    openers.forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            openModal(btn.getAttribute('data-address-mode') || 'add');
        });
    });

    closers.forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            closeModal();
        });
    });

    if (confirmBtn) {
        confirmBtn.addEventListener('click', function (e) {
            e.preventDefault();
            if (!validateModalFields()) return;
            syncShippingFromBilling();
            updatePreview();
            closeModal();
            triggerCheckoutUpdate();
        });
    }

    modal.addEventListener('click', function (e) {
        if (e.target === modal || e.target.hasAttribute('data-address-modal-close')) {
            closeModal();
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !modal.hidden) closeModal();
    });

    var $ = $jq();
    if ($) {
        $(document.body).on('country_to_state_changed updated_checkout', function () {
            if (!modal.hidden) {
                setTimeout(useNativeSelects, 20);
                setTimeout(useNativeSelects, 150);
            }
        });
        $(modal).on('change', '#billing_country', function () {
            setTimeout(useNativeSelects, 100);
            setTimeout(useNativeSelects, 250);
        });
    }

    useNativeSelects();
    setTimeout(useNativeSelects, 300);

    document.body.addEventListener('click', function (e) {
        var placeOrder = e.target.closest('#place_order');
        if (!placeOrder) return;
        if (!hasAddress()) {
            e.preventDefault();
            e.stopPropagation();
            openModal('add');
            return;
        }
        if (!validateModalFields()) {
            e.preventDefault();
            e.stopPropagation();
            openModal('edit');
        }
    }, true);

    updatePreview();
}

/**
 * Franja login/cup?n del checkout (sustituye avisos WC).
 */
function initCheckoutHelpers() {
    var buttons = document.querySelectorAll('[data-doro-checkout-toggle]');
    if (!buttons.length) return;

    buttons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var type = btn.getAttribute('data-doro-checkout-toggle');
            var panel = document.getElementById(type === 'login' ? 'doro-checkout-login-panel' : 'doro-checkout-coupon-panel');
            if (!panel) return;

            var willOpen = panel.hasAttribute('hidden');
            document.querySelectorAll('.doro-checkout-panel').forEach(function (el) {
                el.hidden = true;
                el.setAttribute('hidden', '');
            });
            document.querySelectorAll('[data-doro-checkout-toggle]').forEach(function (other) {
                other.setAttribute('aria-expanded', 'false');
            });

            if (willOpen) {
                panel.hidden = false;
                panel.removeAttribute('hidden');
                btn.setAttribute('aria-expanded', 'true');
                var focusEl = panel.querySelector('input:not([type="hidden"]), button');
                if (focusEl && typeof focusEl.focus === 'function') {
                    setTimeout(function () { focusEl.focus(); }, 40);
                }
            }
        });
    });
}

/**
 * Prefija pa?s de facturaci?n/env?o desde cookie (Klarna / Stripe locales).
 */
function initCheckoutCountrySeed() {
    if (!document.body.classList.contains('woocommerce-checkout') && !document.querySelector('.doro-checkout-form')) {
        return;
    }

    function readCookie(name) {
        var match = document.cookie.match(new RegExp('(?:^|; )' + name.replace(/([.$?*|{}()[\]\\/+^])/g, '\\$1') + '=([^;]*)'));
        return match ? decodeURIComponent(match[1]) : '';
    }

    var fromCookie = (readCookie('doroshopping_country') || '').toUpperCase().slice(0, 2);
    if (fromCookie === 'UK') fromCookie = 'GB';
    var country = fromCookie || 'ES';

    ['billing_country', 'shipping_country'].forEach(function (id) {
        var el = document.getElementById(id);
        if (!el) return;
        if (!el.value) {
            el.value = country;
            if (window.jQuery) {
                window.jQuery(el).trigger('change');
            }
        }
    });

    if (window.jQuery) {
        setTimeout(function () {
            window.jQuery(document.body).trigger('update_checkout');
        }, 400);
    }
}

/**
 * Oculta el aviso t?cnico de zona de coincidencia si el filtro PHP no llega a tiempo.
 */
function hideTechnicalCheckoutNotices() {
    function scrub() {
        document.querySelectorAll('.woocommerce-message, .woocommerce-info').forEach(function (el) {
            var text = (el.textContent || '').toLowerCase();
            if (text.indexOf('zona de coincidencia') !== -1 || text.indexOf('matching zone') !== -1) {
                el.classList.add('doro-notice-hidden');
                el.setAttribute('hidden', '');
            }
        });
    }
    scrub();
    if (window.jQuery) {
        window.jQuery(document.body).on('updated_checkout', scrub);
    }
}

/**
 * Tienda: bot?n ?Ver m?s? carga la siguiente p?gina y a?ade productos al grid.
 */
function initShopLoadMore() {
    var wrap = document.querySelector('[data-doro-load-more]');
    var btn = wrap ? wrap.querySelector('[data-doro-load-more-btn]') : null;
    if (!btn) return;

    var grid = document.querySelector('.doro-shop ul.products, .woocommerce ul.products');
    if (!grid) return;

    var loading = false;
    var labelDefault = btn.textContent;

    btn.addEventListener('click', function () {
        if (loading) return;
        var nextUrl = btn.getAttribute('data-next-url');
        if (!nextUrl) return;

        loading = true;
        btn.classList.add('is-loading');
        btn.disabled = true;
        btn.textContent = (window.doroshoppingI18n && window.doroshoppingI18n.loading) ? window.doroshoppingI18n.loading : 'Cargando…';

        fetch(nextUrl, { credentials: 'same-origin' })
            .then(function (res) { return res.text(); })
            .then(function (html) {
                var parser = new DOMParser();
                var doc = parser.parseFromString(html, 'text/html');
                var nextItems = doc.querySelectorAll('.doro-shop ul.products > li.product, .woocommerce ul.products > li.product');
                nextItems.forEach(function (item) {
                    grid.appendChild(document.importNode(item, true));
                });

                var nextBtn = doc.querySelector('[data-doro-load-more-btn]');
                if (nextBtn && nextBtn.getAttribute('data-next-url')) {
                    btn.setAttribute('data-next-url', nextBtn.getAttribute('data-next-url'));
                    btn.setAttribute('data-next-page', nextBtn.getAttribute('data-next-page') || '');
                    btn.setAttribute('data-total-pages', nextBtn.getAttribute('data-total-pages') || '');
                    btn.disabled = false;
                    btn.classList.remove('is-loading');
                    btn.textContent = labelDefault;
                } else {
                    if (wrap) wrap.remove();
                }

                if (window.jQuery) {
                    window.jQuery(document.body).trigger('doro_products_loaded');
                }
            })
            .catch(function () {
                window.location.href = nextUrl;
            })
            .finally(function () {
                loading = false;
            });
    });
}

/**
 * Filtro de categorías: desplegar / plegar subcategorías.
 */
function initShopCategoryFilter() {
    var root = document.querySelector('.doro-shop__filter-list--cats');
    if (!root) return;

    root.addEventListener('click', function (e) {
        var btn = e.target.closest('[data-doro-cat-toggle]');
        if (!btn || !root.contains(btn)) return;

        e.preventDefault();
        e.stopPropagation();

        var item = btn.closest('.doro-shop__cat-item');
        var panelId = btn.getAttribute('aria-controls');
        var panel = panelId ? document.getElementById(panelId) : (item ? item.querySelector(':scope > .doro-shop__subcats') : null);
        if (!item || !panel) return;

        var willOpen = panel.hasAttribute('hidden');
        if (willOpen) {
            panel.hidden = false;
            panel.removeAttribute('hidden');
            item.classList.add('is-open');
            btn.setAttribute('aria-expanded', 'true');
        } else {
            panel.hidden = true;
            panel.setAttribute('hidden', '');
            item.classList.remove('is-open');
            btn.setAttribute('aria-expanded', 'false');
        }
    });
}

/**
 * Móvil: filtros en barra horizontal con desplegables (estilo AliExpress).
 */
function initShopMobileFilters() {
    var roots = Array.prototype.slice.call(document.querySelectorAll('[data-doro-filters]'));
    if (!roots.length) return;

    var mq = window.matchMedia('(max-width: 900px)');
    var chevron = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>';

    function closeAll(except) {
        roots.forEach(function (root) {
            root.querySelectorAll('.doro-shop__widget.is-open, .doro-filter-sort.is-open').forEach(function (el) {
                if (except && el === except) return;
                el.classList.remove('is-open');
                var chip = el.querySelector('.doro-filter-chip');
                if (chip) chip.setAttribute('aria-expanded', 'false');
            });
        });
    }

    function ensureChip(widget) {
        if (widget.querySelector(':scope > .doro-filter-chip')) return;
        var title = widget.querySelector(':scope > .doro-shop__widget-title');
        var label = widget.getAttribute('data-filter-label')
            || (title ? title.textContent.trim() : 'Filtro');
        var btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'doro-filter-chip';
        btn.setAttribute('aria-expanded', 'false');
        btn.innerHTML = '<span>' + label + '</span>' + chevron;
        widget.insertBefore(btn, widget.firstChild);

        if (widget.querySelector('a.is-active, a[aria-current="true"], a[aria-current="page"]')) {
            btn.classList.add('is-active');
        }
    }

    function ensureSortChip(root) {
        if (root.querySelector('.doro-filter-sort')) return;
        var ordering = document.querySelector('.doro-shop__toolbar .woocommerce-ordering, .woocommerce-ordering');
        if (!ordering) return;

        var host = root.querySelector('.doro-shop__sidebar, .doro-category__filters-card') || root;
        var wrap = document.createElement('div');
        wrap.className = 'doro-shop__widget doro-filter-sort';
        wrap.setAttribute('data-doro-filter-widget', '');

        var btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'doro-filter-chip';
        btn.setAttribute('aria-expanded', 'false');
        btn.innerHTML = '<span>Ordenar por</span>' + chevron;

        var panel = document.createElement('div');
        panel.className = 'doro-filter-panel';
        var clone = ordering.cloneNode(true);
        clone.classList.add('doro-filter-ordering');
        panel.appendChild(clone);

        wrap.appendChild(btn);
        wrap.appendChild(panel);
        host.insertBefore(wrap, host.firstChild);

        var select = panel.querySelector('select');
        if (select) {
            select.addEventListener('change', function () {
                var original = ordering.querySelector('select');
                if (original) {
                    original.value = select.value;
                    if (typeof jQuery !== 'undefined') {
                        jQuery(original).val(select.value).trigger('change');
                    } else if (original.form) {
                        original.form.submit();
                    }
                }
            });
        }
    }

    function setupRoot(root) {
        var widgets = Array.prototype.slice.call(root.querySelectorAll('.doro-shop__widget'));
        widgets.forEach(ensureChip);
        ensureSortChip(root);

        root.addEventListener('click', function (e) {
            if (!mq.matches) return;
            var chip = e.target.closest('.doro-filter-chip');
            if (!chip || !root.contains(chip)) return;
            e.preventDefault();
            e.stopPropagation();
            var widget = chip.closest('.doro-shop__widget, .doro-filter-sort');
            if (!widget) return;
            var willOpen = !widget.classList.contains('is-open');
            closeAll(widget);
            widget.classList.toggle('is-open', willOpen);
            chip.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
        });
    }

    roots.forEach(setupRoot);

    document.addEventListener('click', function (e) {
        if (!mq.matches) return;
        if (e.target.closest('[data-doro-filters] .doro-shop__widget, [data-doro-filters] .doro-filter-sort')) return;
        closeAll();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeAll();
    });
}

/**
 * Home: Ver m?s carga lotes de 30 hasta el m?ximo del Customizer; luego ? tienda.
 */
function initHomeLoadMore() {
    var section = document.querySelector('[data-home-products]');
    if (!section) return;

    var grid = section.querySelector('[data-home-products-grid]');
    var wrap = section.querySelector('[data-home-load-more]');
    var btn = section.querySelector('[data-home-load-more-btn]');
    if (!grid || !wrap) return;

    var cfg = window.doroshoppingHome || {};
    var ajaxUrl = cfg.ajaxUrl || '';
    var nonce = cfg.nonce || '';
    var i18n = cfg.i18n || {};
    var loading = false;

    function switchToShop() {
        var shopUrl = section.getAttribute('data-shop-url') || '/';
        wrap.innerHTML = '';
        var link = document.createElement('a');
        link.className = 'doro-load-more__btn';
        link.href = shopUrl;
        link.textContent = i18n.viewShop || 'Ver más en la tienda';
        wrap.appendChild(link);
    }

    if (!btn) return;

    btn.addEventListener('click', function () {
        if (loading || !ajaxUrl) return;

        var page = parseInt(section.getAttribute('data-page') || '1', 10) + 1;
        var shown = parseInt(section.getAttribute('data-shown') || '0', 10);
        var max = parseInt(section.getAttribute('data-max') || '90', 10);
        var batch = parseInt(section.getAttribute('data-batch') || '30', 10);
        var catId = section.getAttribute('data-cat-id') || '0';

        if (shown >= max) {
            switchToShop();
            return;
        }

        loading = true;
        btn.disabled = true;
        btn.classList.add('is-loading');
        btn.textContent = i18n.loading || 'Cargando…';

        var body = new FormData();
        body.append('action', 'doroshopping_home_load_more');
        body.append('nonce', nonce);
        body.append('page', String(page));
        body.append('shown', String(shown));
        body.append('max', String(max));
        body.append('batch', String(batch));
        body.append('cat_id', String(catId));

        fetch(ajaxUrl, { method: 'POST', credentials: 'same-origin', body: body })
            .then(function (res) { return res.json(); })
            .then(function (json) {
                if (!json || !json.success || !json.data) {
                    throw new Error('bad response');
                }
                var data = json.data;
                if (data.html) {
                    var tmp = document.createElement('div');
                    tmp.innerHTML = data.html;
                    while (tmp.firstChild) {
                        grid.appendChild(tmp.firstChild);
                    }
                }

                section.setAttribute('data-page', String(data.page || page));
                section.setAttribute('data-shown', String(data.shown != null ? data.shown : shown));

                if (data.go_to_shop || data.done || !data.count) {
                    switchToShop();
                    return;
                }

                btn.disabled = false;
                btn.classList.remove('is-loading');
                btn.textContent = i18n.viewMore || 'Ver más';
            })
            .catch(function () {
                switchToShop();
            })
            .finally(function () {
                loading = false;
            });
    });
}

function initAuthModal() {
    var modal = document.getElementById('doro-auth-modal');
    if (!modal) return;

    function closeDropdowns() {
        document.querySelectorAll('.site-header__dropdown-wrap.is-open').forEach(function (wrap) {
            var btn = wrap.querySelector('.site-header__utility-btn');
            var panel = wrap.querySelector('.header-dropdown');
            if (panel) panel.hidden = true;
            wrap.classList.remove('is-open');
            if (btn) btn.setAttribute('aria-expanded', 'false');
        });
    }

    function openModal() {
        closeDropdowns();
        modal.hidden = false;
        modal.removeAttribute('hidden');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('doro-auth-modal-open');
        var first = modal.querySelector('input:not([type="hidden"])');
        if (first && typeof first.focus === 'function') {
            setTimeout(function () { first.focus(); }, 40);
        }
    }

    function closeModal() {
        var active = document.activeElement;
        if (active && modal.contains(active) && typeof active.blur === 'function') {
            active.blur();
        }
        modal.setAttribute('aria-hidden', 'true');
        modal.hidden = true;
        document.body.classList.remove('doro-auth-modal-open');
    }

    // Capture: el dropdown usa stopPropagation y si no, el clic no llega al document.
    document.addEventListener('click', function (e) {
        var opener = e.target.closest('[data-auth-modal-open]');
        if (opener) {
            e.preventDefault();
            e.stopPropagation();
            openModal();
            return;
        }
        if (modal.hidden) return;
        if (e.target.closest('[data-auth-modal-close]') || e.target.classList.contains('doro-auth-modal__backdrop')) {
            closeModal();
        }
    }, true);

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !modal.hidden) closeModal();
    });

    document.addEventListener('doroshopping:open-auth-modal', openModal);
    window.doroshoppingOpenAuthModal = openModal;

    document.addEventListener('click', function (e) {
        var googleBtn = e.target.closest('[data-google-pending="1"]');
        if (!googleBtn) return;
        e.preventDefault();
        e.stopPropagation();
        window.alert('Configura el login con Google: activa Nextend Social Login (o pega la URL en Apariencia > Personalizar > DoroTheme > Login / Google).');
    }, true);
}

function initHeaderDropdowns() {
    var wraps = Array.prototype.slice.call(document.querySelectorAll('.site-header__dropdown-wrap'));
    if (!wraps.length) return;

    function closeAll() {
        wraps.forEach(function (wrap) {
            var btn = wrap.querySelector('.site-header__utility-btn');
            var panel = wrap.querySelector('.header-dropdown');
            if (panel) {
                var active = document.activeElement;
                if (active && panel.contains(active) && typeof active.blur === 'function') {
                    active.blur();
                }
                panel.hidden = true;
            }
            wrap.classList.remove('is-open');
            if (btn) btn.setAttribute('aria-expanded', 'false');
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

        panel.querySelectorAll('[data-dropdown-close]').forEach(function (closeBtn) {
            closeBtn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                closeAll();
            });
        });
    });

    document.addEventListener('click', closeAll);

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeAll();
    });
}

function initLocaleFlagOptions() {
    var selects = Array.prototype.slice.call(document.querySelectorAll('[data-locale-select]'));
    if (!selects.length) return;

    var headerFlag = document.querySelector('.site-header__flag');
    var headerLangLabel = document.querySelector('[aria-controls="dropdown-locale"] .site-header__utility-label');
    var localeMap = (window.doroshoppingShipping && window.doroshoppingShipping.localeMap) || {};

    function closeSelect(select) {
        var toggle = select.querySelector('[data-locale-toggle]');
        var menu = select.querySelector('[data-locale-menu]');
        select.classList.remove('is-open');
        if (toggle) toggle.setAttribute('aria-expanded', 'false');
        if (menu) menu.hidden = true;
    }

    function closeAll(except) {
        selects.forEach(function (select) {
            if (except && select === except) return;
            closeSelect(select);
        });
    }

    function setSelectValue(fieldName, value) {
        if (!value) return;
        var select = document.querySelector('[data-locale-select="' + fieldName + '"]');
        if (!select) return;
        var input = select.querySelector('input[type="hidden"]');
        var valueWrap = select.querySelector('.header-locale-select__value');
        var options = Array.prototype.slice.call(select.querySelectorAll('.header-locale-select__option'));
        var match = options.filter(function (btn) {
            return (btn.getAttribute('data-value') || '').toLowerCase() === String(value).toLowerCase();
        })[0];
        if (!match) return;

        options.forEach(function (other) {
            var selected = other === match;
            other.classList.toggle('is-selected', selected);
            other.setAttribute('aria-selected', selected ? 'true' : 'false');
        });
        if (input) input.value = match.getAttribute('data-value') || value;

        if (valueWrap) {
            var flag = match.getAttribute('data-flag') || '';
            var label = match.getAttribute('data-label') || '';
            valueWrap.innerHTML = '';
            if (flag) {
                var img = document.createElement('img');
                img.className = 'header-locale-select__flag';
                img.src = flag;
                img.alt = '';
                img.width = 16;
                img.height = 16;
                valueWrap.appendChild(img);
            }
            var text = document.createElement('span');
            text.className = 'header-locale-select__text';
            text.textContent = label;
            valueWrap.appendChild(text);
        }

        if (fieldName === 'lengua' && headerLangLabel) {
            headerLangLabel.textContent = match.getAttribute('data-label') || value;
        }
    }

    function setCurrency(code) {
        if (!code) return;
        code = String(code).toUpperCase();
        setSelectValue('divisa', code);

        var fallback = document.getElementById('locale-divisa');
        if (fallback && fallback.tagName === 'SELECT') {
            fallback.value = code;
        }

        // CURCY / Yay / selectores de plugin (slot oculto).
        var slot = document.querySelector('[data-curcy-currency-slot], [data-yay-currency-slot], .site-header__plugin-slot--currency');
        if (!slot) return;
        var selectsInSlot = slot.querySelectorAll('select');
        selectsInSlot.forEach(function (sel) {
            var opts = Array.prototype.slice.call(sel.options || []);
            var found = opts.filter(function (opt) {
                var v = String(opt.value || '').toUpperCase();
                var t = String(opt.text || '').toUpperCase();
                return v === code || v.indexOf(code) !== -1 || t.indexOf(code) !== -1;
            })[0];
            if (found) {
                sel.value = found.value;
                if (window.jQuery) {
                    window.jQuery(sel).trigger('change');
                } else {
                    sel.dispatchEvent(new Event('change', { bubbles: true }));
                }
            }
        });
        // CURCY enlaces data-currency.
        var link = slot.querySelector('[data-currency="' + code + '"], a[href*="wmc-currency=' + code + '"]');
        if (link && typeof link.click === 'function' && !link.classList.contains('wmc-active')) {
            // No auto-click al elegir ubicaci?n (evitar navegaci?n doble); Guardar aplica ?wmc-currency=.
        }
    }

    function applyLocationDefaults(countryCode, btn) {
        var code = String(countryCode || '').toUpperCase();
        if (code === 'UK') code = 'GB';
        var fromBtnLang = btn ? btn.getAttribute('data-lang') : '';
        var fromBtnCur = btn ? btn.getAttribute('data-currency') : '';
        var mapped = localeMap[code] || {};
        // Ubicación sugiere idioma + moneda; el usuario puede cambiar el idioma después.
        var lang = fromBtnLang || mapped.lang || '';
        var currency = fromBtnCur || mapped.currency || '';
        if (lang) setSelectValue('lengua', lang);
        if (currency) setCurrency(currency);
    }

    selects.forEach(function (select) {
        var field = select.getAttribute('data-locale-select');
        var toggle = select.querySelector('[data-locale-toggle]');
        var menu = select.querySelector('[data-locale-menu]');
        var input = select.querySelector('input[type="hidden"]');
        var valueWrap = select.querySelector('.header-locale-select__value');
        var options = Array.prototype.slice.call(select.querySelectorAll('.header-locale-select__option'));

        if (!toggle || !menu || !valueWrap) return;

        toggle.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var isOpen = select.classList.contains('is-open');
            closeAll();
            if (!isOpen) {
                select.classList.add('is-open');
                toggle.setAttribute('aria-expanded', 'true');
                menu.hidden = false;
            }
        });

        options.forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                var value = btn.getAttribute('data-value') || '';
                var flag = btn.getAttribute('data-flag') || '';
                var label = btn.getAttribute('data-label') || '';

                options.forEach(function (other) {
                    var selected = other === btn;
                    other.classList.toggle('is-selected', selected);
                    other.setAttribute('aria-selected', selected ? 'true' : 'false');
                });

                if (input) input.value = value;

                valueWrap.innerHTML = '';
                if (flag) {
                    var img = document.createElement('img');
                    img.className = 'header-locale-select__flag';
                    img.src = flag;
                    img.alt = '';
                    img.width = 16;
                    img.height = 16;
                    valueWrap.appendChild(img);
                }
                var text = document.createElement('span');
                text.className = 'header-locale-select__text';
                text.textContent = label;
                valueWrap.appendChild(text);

                if (field === 'ubicacion') {
                    if (headerFlag && flag) headerFlag.src = flag;
                    applyLocationDefaults(value, btn);
                }
                if (field === 'lengua' && headerLangLabel && label) {
                    headerLangLabel.textContent = label;
                }

                closeSelect(select);
            });
        });
    });

    document.addEventListener('click', function () {
        closeAll();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeAll();
    });

    // Guardar: feedback inmediato (sin texto; solo estado de carga).
    var form = document.querySelector('[data-locale-form]');
    if (form) {
        form.addEventListener('submit', function () {
            var btn = form.querySelector('.header-dropdown__submit');
            if (btn) {
                btn.disabled = true;
                btn.classList.add('is-loading');
                btn.setAttribute('aria-busy', 'true');
                btn.textContent = '';
            }
        });
    }
}

function initMegaMenu() {
    var categoryBtns = Array.prototype.slice.call(document.querySelectorAll('.site-nav__categories-btn'));
    var menuWrap = document.querySelector('.site-header__menu-wrap') || document.querySelector('.site-nav__categories');
    var megaMenu = document.getElementById('mega-menu');

    function setExpanded(expanded) {
        categoryBtns.forEach(function (btn) {
            btn.setAttribute('aria-expanded', expanded ? 'true' : 'false');
        });
        document.querySelectorAll('.site-nav__categories, .site-header__menu-wrap').forEach(function (wrap) {
            wrap.classList.toggle('is-open', expanded);
        });
    }

    function openMegaMenu() {
        if (!megaMenu) return;
        megaMenu.hidden = false;
        setExpanded(true);
    }

    function closeMegaMenu() {
        if (!megaMenu) return;
        megaMenu.hidden = true;
        setExpanded(false);
    }

    if (categoryBtns.length && megaMenu) {
        categoryBtns.forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                if (megaMenu.hidden) {
                    openMegaMenu();
                } else {
                    closeMegaMenu();
                }
            });
        });

        document.addEventListener('click', function (e) {
            var insideBtn = categoryBtns.some(function (btn) { return btn.contains(e.target); });
            var insideMenu = megaMenu.contains(e.target);
            var insideWrap = menuWrap && menuWrap.contains(e.target);
            if (!insideBtn && !insideMenu && !insideWrap) {
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
            var href = btn.getAttribute('href');
            // Si es enlace real a la categor?a, permitir navegaci?n.
            if (href && href !== '#' && href.indexOf('javascript:') !== 0) {
                return;
            }
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
    var gap = 12;
    var intervalMs = 4000;

    function getVisibleCount() {
        if (window.innerWidth <= 560) return 1;
        if (window.innerWidth <= 1024) return 2;
        return 3;
    }

    blocks.forEach(function (block) {
        var wrap = block.querySelector('.home-categories__carousel-wrap');
        var track = block.querySelector('.home-categories__carousel-track');
        var carousel = block.querySelector('.home-categories__carousel');
        var products = block.querySelectorAll('.home-categories__product');
        var dotsWrap = block.querySelector('[data-dots]');
        var prevBtn = block.querySelector('.home-categories__arrow--prev');
        var nextBtn = block.querySelector('.home-categories__arrow--next');

        if (!track || !carousel || products.length === 0) return;

        var current = 0;
        var timer = null;
        var pageCount = 1;

        function rebuildDots() {
            if (!dotsWrap) return;
            dotsWrap.innerHTML = '';
            for (var i = 0; i < pageCount; i++) {
                var dot = document.createElement('button');
                dot.type = 'button';
                dot.className = 'home-categories__dot' + (i === current ? ' is-active' : '');
                dot.setAttribute('data-page', String(i));
                dot.setAttribute('aria-label', 'Pagina ' + (i + 1));
                dotsWrap.appendChild(dot);
            }
            dotsWrap.querySelectorAll('.home-categories__dot').forEach(function (dot) {
                dot.addEventListener('click', function () {
                    goTo(parseInt(dot.getAttribute('data-page'), 10));
                    startAuto();
                });
            });
        }

        function goTo(page) {
            var visible = getVisibleCount();
            pageCount = Math.max(1, Math.ceil(products.length / visible));
            if (current >= pageCount) current = 0;
            current = ((page % pageCount) + pageCount) % pageCount;

            track.style.transform = 'translateX(0)';
            var productWidth = products[0].getBoundingClientRect().width;
            var shift = current * visible * (productWidth + gap);
            track.style.transform = shift > 0 ? 'translateX(-' + shift + 'px)' : '';

            if (dotsWrap) {
                var dots = dotsWrap.querySelectorAll('.home-categories__dot');
                if (dots.length !== pageCount) rebuildDots();
                dots = dotsWrap.querySelectorAll('.home-categories__dot');
                dots.forEach(function (dot, i) {
                    dot.classList.toggle('is-active', i === current);
                });
            }
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

        if (wrap) {
            wrap.addEventListener('mouseenter', stopAuto);
            wrap.addEventListener('mouseleave', startAuto);
        }

        var resizeTimer;
        window.addEventListener('resize', function () {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function () {
                goTo(current);
            }, 100);
        });

        goTo(0);
        startAuto();
    });
}

function initRelatedProductsCarousel() {
    var roots = document.querySelectorAll('[data-product-carousel], [data-related-carousel]');
    if (!roots.length) return;

    var intervalMs = 2800;

    function getVisibleCount() {
        if (window.innerWidth <= 480) return 2;
        if (window.innerWidth <= 768) return 3;
        if (window.innerWidth <= 1100) return 4;
        return 5;
    }

    function getGap(list) {
        var style = window.getComputedStyle(list);
        var gap = parseFloat(style.columnGap || style.gap);
        return isNaN(gap) ? 12 : gap;
    }

    roots.forEach(function (root) {
        if (root.getAttribute('data-carousel-ready') === '1') return;

        var list = root.querySelector('ul.products');
        if (!list) return;

        var items = Array.prototype.slice.call(list.children).filter(function (el) {
            return el.nodeType === 1 && el.classList.contains('product');
        });
        if (items.length < 2) return;

        root.setAttribute('data-carousel-ready', '1');

        var carousel = document.createElement('div');
        carousel.className = 'doro-related-carousel';

        var viewport = document.createElement('div');
        viewport.className = 'doro-related-carousel__viewport';

        list.parentNode.insertBefore(carousel, list);
        viewport.appendChild(list);
        carousel.appendChild(viewport);

        list.classList.add('is-carousel-track');

        var prevBtn = document.createElement('button');
        prevBtn.type = 'button';
        prevBtn.className = 'doro-related-carousel__btn doro-related-carousel__btn--prev';
        prevBtn.setAttribute('aria-label', 'Anterior');
        prevBtn.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M15 18l-6-6 6-6"/></svg>';

        var nextBtn = document.createElement('button');
        nextBtn.type = 'button';
        nextBtn.className = 'doro-related-carousel__btn doro-related-carousel__btn--next';
        nextBtn.setAttribute('aria-label', 'Siguiente');
        nextBtn.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M9 18l6-6-6-6"/></svg>';

        var dotsWrap = document.createElement('div');
        dotsWrap.className = 'doro-related-carousel__dots';
        dotsWrap.setAttribute('role', 'tablist');

        carousel.appendChild(prevBtn);
        carousel.appendChild(nextBtn);
        carousel.appendChild(dotsWrap);

        var current = 0;
        var timer = null;
        var maxIndex = 0;
        var pageCount = 1;

        function rebuildDots() {
            dotsWrap.innerHTML = '';
            for (var i = 0; i < pageCount; i++) {
                var dot = document.createElement('button');
                dot.type = 'button';
                dot.className = 'doro-related-carousel__dot' + (Math.floor(current / getVisibleCount()) === i ? ' is-active' : '');
                dot.setAttribute('aria-label', 'Pagina ' + (i + 1));
                dot.setAttribute('data-page', String(i));
                dotsWrap.appendChild(dot);
            }
            dotsWrap.querySelectorAll('.doro-related-carousel__dot').forEach(function (dot) {
                dot.addEventListener('click', function () {
                    goTo(parseInt(dot.getAttribute('data-page'), 10) * getVisibleCount());
                    startAuto();
                });
            });
        }

        function updateButtons() {
            var multi = maxIndex > 0;
            prevBtn.disabled = !multi;
            nextBtn.disabled = !multi;
            dotsWrap.style.display = multi ? '' : 'none';
            prevBtn.style.display = multi ? '' : 'none';
            nextBtn.style.display = multi ? '' : 'none';
        }

        function goTo(index) {
            var visible = getVisibleCount();
            var gap = getGap(list);
            maxIndex = Math.max(0, items.length - visible);
            pageCount = Math.max(1, Math.ceil(items.length / visible));
            current = ((index % (maxIndex + 1)) + (maxIndex + 1)) % (maxIndex + 1);

            var productWidth = items[0].getBoundingClientRect().width;
            var shift = current * (productWidth + gap);
            list.style.transform = shift > 0 ? 'translateX(-' + shift + 'px)' : 'translateX(0)';

            if (dotsWrap.children.length !== pageCount) rebuildDots();
            var activePage = Math.min(pageCount - 1, Math.floor(current / visible));
            dotsWrap.querySelectorAll('.doro-related-carousel__dot').forEach(function (dot, i) {
                dot.classList.toggle('is-active', i === activePage);
            });
            updateButtons();
        }

        function next() {
            goTo(current + 1);
        }

        function prev() {
            goTo(current - 1);
        }

        function startAuto() {
            stopAuto();
            if (maxIndex < 1) return;
            timer = setInterval(next, intervalMs);
        }

        function stopAuto() {
            if (timer) {
                clearInterval(timer);
                timer = null;
            }
        }

        prevBtn.addEventListener('click', function () {
            prev();
            startAuto();
        });
        nextBtn.addEventListener('click', function () {
            next();
            startAuto();
        });

        carousel.addEventListener('mouseenter', stopAuto);
        carousel.addEventListener('mouseleave', startAuto);

        var touchStartX = 0;
        var touchDelta = 0;
        viewport.addEventListener('touchstart', function (e) {
            if (!e.touches.length) return;
            touchStartX = e.touches[0].clientX;
            touchDelta = 0;
            stopAuto();
        }, { passive: true });
        viewport.addEventListener('touchmove', function (e) {
            if (!e.touches.length) return;
            touchDelta = e.touches[0].clientX - touchStartX;
        }, { passive: true });
        viewport.addEventListener('touchend', function () {
            if (Math.abs(touchDelta) > 36) {
                if (touchDelta < 0) next();
                else prev();
            }
            startAuto();
        });

        var resizeTimer;
        window.addEventListener('resize', function () {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function () {
                goTo(current);
            }, 100);
        });

        goTo(0);
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
    var loading = false;

    function isPreviewMode() {
        return !!(window.doroshoppingPreviewCart && typeof window.doroshoppingPreviewCart.handle === 'function');
    }

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
        var active = document.activeElement;
        if (active && modal.contains(active) && typeof active.blur === 'function') {
            active.blur();
        }
        fab.setAttribute('aria-expanded', 'false');
        document.body.classList.remove('cart-modal-open');
        modal.setAttribute('aria-hidden', 'true');
        modal.hidden = true;
        if (typeof fab.focus === 'function') {
            fab.focus();
        }
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
            subtotalEl.innerHTML = data.subtotal_html || '&mdash;';
        }

        if (checkoutEl) {
            if (data.checkout_url) checkoutEl.setAttribute('href', data.checkout_url);
            checkoutEl.classList.toggle('is-disabled', items.length === 0);
        }

        if (!itemsEl) return;

        if (!items.length) {
            itemsEl.innerHTML = '<p class="cart-modal__empty">' + escapeHtml(data.empty_message || i18n('empty', 'Tu carrito esta vacio.')) + '</p>';
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
                                    '<button type="button" class="cart-modal__qty-btn" data-cart-qty="' + escapeHtml(item.key) + '" data-delta="-1" aria-label="' + escapeHtml(i18n('decrease', 'Reducir cantidad')) + '">&minus;</button>' +
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
        if (isPreviewMode()) {
            return Promise.resolve(window.doroshoppingPreviewCart.handle(action, payload));
        }

        if (!cfg.ajaxUrl || !cfg.nonce) {
            return Promise.resolve({
                items: [],
                count: 0,
                subtotal_html: '&mdash;',
                checkout_url: cfg.checkoutUrl || '#',
                recommendations: [],
                empty_message: i18n('empty', 'Tu carrito esta vacio.')
            });
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
        // Preview: contadores ya se sincronizan desde localStorage en preview-data.js.
        // WP: fragments de WooCommerce actualizan el contador; no llamar get_cart aqui.
        if (window.doroshoppingPreviewCart && !modal.hidden) {
            setTimeout(function () { refreshCart(); }, 50);
        }
    });

    document.body.addEventListener('removed_from_cart', function () {
        setTimeout(function () { refreshCart(); }, 300);
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

        var mobileMq = typeof window.matchMedia === 'function'
            ? window.matchMedia('(max-width: 1100px)')
            : null;

        function escapeHtml(str) {
            return String(str == null ? '' : str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
        }

        function syncPanelPosition() {
            if (!mobileMq || !mobileMq.matches) {
                wrap.classList.remove('is-live-search-open');
                wrap.style.removeProperty('--live-search-left');
                wrap.style.removeProperty('--live-search-width');
                wrap.style.removeProperty('--live-search-top');
                wrap.style.removeProperty('--live-search-max-height');
                return;
            }

            var rect = input.getBoundingClientRect();
            var gutter = 12;
            var left = Math.max(gutter, rect.left);
            var width = Math.min(rect.width, window.innerWidth - (gutter * 2));
            if (left + width > window.innerWidth - gutter) {
                left = Math.max(gutter, window.innerWidth - gutter - width);
            }

            wrap.style.setProperty('--live-search-left', left + 'px');
            wrap.style.setProperty('--live-search-width', width + 'px');
            wrap.style.setProperty('--live-search-top', (rect.bottom + 8) + 'px');
            wrap.style.setProperty(
                '--live-search-max-height',
                Math.max(160, window.innerHeight - rect.bottom - 16) + 'px'
            );
        }

        function openPanel() {
            panel.hidden = false;
            input.setAttribute('aria-expanded', 'true');
            if (mobileMq && mobileMq.matches) {
                wrap.classList.add('is-live-search-open');
                syncPanelPosition();
            }
        }

        function closePanel() {
            panel.hidden = true;
            input.setAttribute('aria-expanded', 'false');
            wrap.classList.remove('is-live-search-open');
            wrap.style.removeProperty('--live-search-left');
            wrap.style.removeProperty('--live-search-width');
            wrap.style.removeProperty('--live-search-top');
            wrap.style.removeProperty('--live-search-max-height');
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
                syncPanelPosition();
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
                        '<div class="live-search__meta">' +
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
            syncPanelPosition();
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
            syncPanelPosition();

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
            } else if (mobileMq && mobileMq.matches && !panel.hidden) {
                syncPanelPosition();
            }
        });

        window.addEventListener('resize', syncPanelPosition);
        window.addEventListener('scroll', syncPanelPosition, true);

        document.addEventListener('click', function (e) {
            if (!wrap.contains(e.target)) closePanel();
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closePanel();
        });
    });
}

/**
 * Add to cart AJAX desde cards (home / tienda / categoria).
 * Usa el endpoint nativo de WooCommerce y actualiza fragments.
 * No llama get_cart despues (evita pisar la sesion).
 */
function initAjaxAddToCart() {
    var cfg = window.doroshoppingCart || {};

    function finish(btn, ok) {
        btn.classList.remove('loading');
        btn.removeAttribute('aria-busy');
        // WooCommerce inserta "Ver carrito" junto al boton; no lo queremos en cards.
        var card = btn.closest('.home-product-card') || btn.parentNode;
        if (card) {
            card.querySelectorAll('a.added_to_cart').forEach(function (link) {
                link.remove();
            });
        }
        if (ok) {
            btn.classList.add('added');
            setTimeout(function () { btn.classList.remove('added'); }, 1800);
        }
    }

    function applyFragments(fragments) {
        if (!fragments || typeof jQuery === 'undefined') return;
        jQuery.each(fragments, function (key, value) {
            jQuery(key).replaceWith(value);
        });
        jQuery(document.body).trigger('wc_fragments_refreshed');
    }

    function addViaWoo(productId, quantity, btn) {
        // Preferir endpoint del tema (sesi?n controlada) si hay nonce.
        if (cfg.ajaxUrl && cfg.nonce) {
            var body = new FormData();
            body.append('action', 'doroshopping_add_to_cart');
            body.append('nonce', cfg.nonce);
            body.append('product_id', productId);
            body.append('quantity', quantity);

            fetch(cfg.ajaxUrl, { method: 'POST', credentials: 'same-origin', body: body })
                .then(function (res) { return res.json(); })
                .then(function (json) {
                    if (!json || !json.success) {
                        finish(btn, false);
                        return;
                    }
                    var data = json.data || {};
                    applyFragments(data.fragments || {});
                    if (typeof data.count !== 'undefined') {
                        document.querySelectorAll('[data-cart-count], .site-header__cart-count, .site-fab-cart__count').forEach(function (el) {
                            el.textContent = String(data.count);
                        });
                    }
                    finish(btn, true);
                    if (typeof jQuery !== 'undefined') {
                        // No pasar el boton: WC insertaria el enlace "Ver carrito".
                        jQuery(document.body).trigger('added_to_cart', [data.fragments || {}, data.cart_hash || '']);
                    } else {
                        document.body.dispatchEvent(new CustomEvent('added_to_cart', { detail: { product_id: productId } }));
                    }
                    // Por si otro script ya inserto el enlace.
                    setTimeout(function () { finish(btn, true); }, 0);
                })
                .catch(function () { finish(btn, false); });
            return;
        }

        var endpoint = '';
        if (typeof wc_add_to_cart_params !== 'undefined' && wc_add_to_cart_params.wc_ajax_url) {
            endpoint = String(wc_add_to_cart_params.wc_ajax_url).replace('%%endpoint%%', 'add_to_cart');
        } else if (cfg.wcAjaxUrl) {
            endpoint = String(cfg.wcAjaxUrl).replace('%%endpoint%%', 'add_to_cart');
        }

        if (!endpoint) {
            finish(btn, false);
            return;
        }

        var data = {
            product_id: productId,
            quantity: quantity
        };

        if (typeof jQuery !== 'undefined') {
            jQuery.ajax({
                type: 'POST',
                url: endpoint,
                data: data,
                dataType: 'json',
                xhrFields: { withCredentials: true }
            }).done(function (response) {
                if (!response) {
                    finish(btn, false);
                    return;
                }
                if (response.error && response.product_url) {
                    window.location = response.product_url;
                    return;
                }
                applyFragments(response.fragments || {});
                finish(btn, true);
                jQuery(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash]);
                setTimeout(function () { finish(btn, true); }, 0);
            }).fail(function () {
                finish(btn, false);
            });
            return;
        }

        finish(btn, false);
    }

    document.addEventListener('click', function (e) {
        var btn = e.target.closest('.home-product-card__cart-btn.ajax_add_to_cart');
        if (!btn) return;

        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();

        if (btn.classList.contains('loading')) return;

        var card = btn.closest('[data-product-id]');
        var productId = btn.getAttribute('data-product_id') || (card && card.getAttribute('data-product-id'));
        if (!productId) return;

        var quantity = btn.getAttribute('data-quantity') || '1';
        btn.classList.add('loading');
        btn.setAttribute('aria-busy', 'true');

        if (window.doroshoppingPreviewCart) {
            if (typeof window.doroshoppingPreviewCart.add === 'function') {
                window.doroshoppingPreviewCart.add(productId, quantity);
            } else if (typeof window.doroshoppingPreviewCart.handle === 'function') {
                var nameEl = card && card.querySelector('.home-product-card__name');
                var imgEl = card && card.querySelector('img');
                var priceEl = card && card.querySelector('.home-product-card__price');
                var unit = priceEl ? parseFloat(String(priceEl.textContent).replace(/[^\d.,]/g, '').replace(',', '.')) : 0;
                window.doroshoppingPreviewCart.handle('doroshopping_add_to_cart', {
                    product: {
                        id: productId,
                        name: nameEl ? nameEl.textContent.trim() : 'Producto',
                        unit: isNaN(unit) ? 0 : unit,
                        image: imgEl ? imgEl.getAttribute('src') : '',
                        permalink: 'product.html'
                    },
                    quantity: quantity
                });
            }
            finish(btn, true);
            document.body.dispatchEvent(new CustomEvent('added_to_cart', { detail: { product_id: productId } }));
            return;
        }

        addViaWoo(productId, quantity, btn);
    }, true);
}

/**
 * Ficha producto: add to cart / buy now en preview (y feedback visual en WP).
 */
function initProductBuybox() {
    var buybox = document.querySelector('[data-doro-buybox]');
    if (!buybox) return;

    var form = buybox.querySelector('form.cart');
    if (!form) return;

    var productId = buybox.getAttribute('data-product-id') || '0';
    var titleEl = document.querySelector('.doro-product__summary .product_title, .product_title');
    var imgEl = document.querySelector('.doro-product__gallery img');
    var priceEl = document.querySelector('.doro-product__summary .price ins, .doro-product__summary .price span, .doro-product__summary .price');

    function parseUnit() {
        if (!priceEl) return 0;
        var n = parseFloat(String(priceEl.textContent).replace(/[^\d.,]/g, '').replace(',', '.'));
        return isNaN(n) ? 0 : n;
    }

    function qty() {
        var input = form.querySelector('input.qty');
        return input ? Math.max(1, parseInt(input.value, 10) || 1) : 1;
    }

    function addPreview(thenCheckout) {
        if (!window.doroshoppingPreviewCart || typeof window.doroshoppingPreviewCart.add !== 'function') {
            return false;
        }
        // Preferir datos visibles de la ficha si el id es preview.
        if (typeof window.doroshoppingPreviewCart.handle === 'function' && titleEl) {
            window.doroshoppingPreviewCart.handle('doroshopping_add_to_cart', {
                product: {
                    id: productId,
                    name: titleEl.textContent.trim(),
                    unit: parseUnit(),
                    image: imgEl ? imgEl.getAttribute('src') : '',
                    permalink: 'product.html'
                },
                quantity: qty()
            });
        } else {
            window.doroshoppingPreviewCart.add(productId, qty());
        }
        document.body.dispatchEvent(new CustomEvent('added_to_cart', { detail: { product_id: productId } }));
        if (thenCheckout) {
            var checkout =
                (window.doroshoppingShipping && window.doroshoppingShipping.checkoutUrl) ||
                (window.doroshoppingCart && window.doroshoppingCart.checkoutUrl) ||
                'checkout.html';
            window.location.href = checkout;
        }
        return true;
    }

    form.querySelectorAll('[name="doroshopping_buy_now"]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            form.setAttribute('data-buy-now', '1');
        });
    });
    form.querySelectorAll('.single_add_to_cart_button').forEach(function (btn) {
        btn.addEventListener('click', function () {
            form.removeAttribute('data-buy-now');
        });
    });

    // Preview: interceptar submit del form (action #) solo en HTML est?tico.
    form.addEventListener('submit', function (e) {
        var isPreview = !!(
            window.doroshoppingShipping &&
            window.doroshoppingShipping.preview === true &&
            window.doroshoppingPreviewCart &&
            typeof window.doroshoppingPreviewCart.add === 'function'
        );
        var buyNow = form.getAttribute('data-buy-now') === '1' ||
            (e.submitter && e.submitter.getAttribute('name') === 'doroshopping_buy_now');

        if (!isPreview) {
            return;
        }

        e.preventDefault();
        addPreview(!!buyNow);
        form.removeAttribute('data-buy-now');
    });

    // Por si el bot?n buy-now es <a> en preview antiguo.
    buybox.querySelectorAll('.doro-buybox__buy-now').forEach(function (btn) {
        if (btn.tagName === 'A') {
            btn.addEventListener('click', function (e) {
                if (!(window.doroshoppingShipping && window.doroshoppingShipping.preview === true)) return;
                if (!(window.doroshoppingPreviewCart && typeof window.doroshoppingPreviewCart.add === 'function')) return;
                e.preventDefault();
                addPreview(true);
            });
        }
    });

    // Feedback visual breve tras add (tambi?n ?til si alg?n plugin hace AJAX).
    document.body.addEventListener('added_to_cart', function () {
        var addBtn = form.querySelector('.single_add_to_cart_button');
        if (!addBtn) return;
        addBtn.classList.add('added');
        setTimeout(function () { addBtn.classList.remove('added'); }, 1600);
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

/**
 * Descripcion del producto: colapsar con boton "Leer mas".
 */
function initProductDescriptionClamp() {
    var panels = Array.prototype.slice.call(document.querySelectorAll(
        '.woocommerce-Tabs-panel--description, #tab-description'
    ));

    if (!panels.length) {
        document.querySelectorAll('.doro-product__below .woocommerce-Tabs-panel').forEach(function (panel) {
            var heading = panel.querySelector('h2');
            if (heading && /descripci[o?]n/i.test(heading.textContent || '')) {
                panels.push(panel);
            }
        });
    }

    panels.forEach(function (panel) {
        if (panel.getAttribute('data-desc-clamp') === '1') return;
        panel.setAttribute('data-desc-clamp', '1');

        var wrap = document.createElement('div');
        wrap.className = 'doro-desc-clamp is-collapsed';

        var inner = document.createElement('div');
        inner.className = 'doro-desc-clamp__inner';

        while (panel.firstChild) {
            inner.appendChild(panel.firstChild);
        }

        var btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'doro-desc-clamp__toggle';
        btn.textContent = 'Leer más';
        btn.setAttribute('aria-expanded', 'false');

        wrap.appendChild(inner);
        wrap.appendChild(btn);
        panel.appendChild(wrap);

        requestAnimationFrame(function () {
            var needsClamp = inner.scrollHeight > 300;
            if (!needsClamp) {
                wrap.classList.remove('is-collapsed');
                btn.hidden = true;
                return;
            }

            btn.addEventListener('click', function () {
                var collapsed = wrap.classList.toggle('is-collapsed');
                // toggle returns true if class was added (= collapsed)
                btn.textContent = collapsed ? 'Leer más' : 'Leer menos';
                btn.setAttribute('aria-expanded', collapsed ? 'false' : 'true');
            });
        });
    });
}

/**
 * Galeria de producto sin FlexSlider: thumbs + imagen principal fiable.
 */
function initProductGalleryThumbs() {
    var gallery = document.querySelector('.doro-product__gallery .woocommerce-product-gallery');
    if (!gallery || gallery.getAttribute('data-doro-gallery') === '1') return;

    var figures = Array.prototype.slice.call(
        gallery.querySelectorAll('.woocommerce-product-gallery__image')
    );
    if (!figures.length) {
        // Puede llegar tarde el HTML; reintentar breve.
        var tries = 0;
        var timer = setInterval(function () {
            tries += 1;
            figures = Array.prototype.slice.call(
                gallery.querySelectorAll('.woocommerce-product-gallery__image')
            );
            if (figures.length || tries > 20) {
                clearInterval(timer);
                if (figures.length) buildGallery(gallery, figures);
            }
        }, 150);
        return;
    }

    buildGallery(gallery, figures);
}

function buildGallery(gallery, figures) {
    if (gallery.getAttribute('data-doro-gallery') === '1') return;
    gallery.setAttribute('data-doro-gallery', '1');
    gallery.classList.add('doro-gallery');

    var items = figures.map(function (fig, index) {
        var img = fig.querySelector('img');
        var link = fig.querySelector('a');
        var full =
            (img && (img.getAttribute('data-large_image') || img.getAttribute('data-src') || img.currentSrc || img.src)) ||
            (link && link.getAttribute('href')) ||
            '';
        var thumb =
            (fig.getAttribute('data-thumb') ||
                (img && (img.getAttribute('data-thumb') || img.currentSrc || img.src))) ||
            full;
        var zoom =
            (img && img.getAttribute('data-large_image')) ||
            (link && link.getAttribute('href')) ||
            full;
        return { fig: fig, img: img, full: full, thumb: thumb, zoom: zoom, index: index };
    }).filter(function (item) {
        return !!item.full;
    });

    if (!items.length) return;

    var rail = document.createElement('div');
    rail.className = 'doro-gallery__rail';

    var btnPrev = document.createElement('button');
    btnPrev.type = 'button';
    btnPrev.className = 'doro-gallery-thumbs__btn doro-gallery-thumbs__btn--prev';
    btnPrev.setAttribute('aria-label', 'Miniaturas anteriores');
    btnPrev.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M18 15l-6-6-6 6"/></svg>';

    var thumbs = document.createElement('div');
    thumbs.className = 'doro-gallery__thumbs';
    thumbs.setAttribute('role', 'listbox');

    var btnNext = document.createElement('button');
    btnNext.type = 'button';
    btnNext.className = 'doro-gallery-thumbs__btn doro-gallery-thumbs__btn--next';
    btnNext.setAttribute('aria-label', 'Miniaturas siguientes');
    btnNext.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>';

    var stage = document.createElement('div');
    stage.className = 'doro-gallery__stage';

    var stageLink = document.createElement('a');
    stageLink.className = 'doro-gallery__stage-link';
    stageLink.href = items[0].zoom || items[0].full;

    var stageImg = document.createElement('img');
    stageImg.className = 'doro-gallery__stage-img';
    stageImg.alt = (items[0].img && items[0].img.alt) || '';
    stageImg.src = items[0].full;
    stageImg.decoding = 'async';

    stageLink.appendChild(stageImg);
    stage.appendChild(stageLink);

    var active = 0;
    var thumbButtons = [];

    function setActive(index) {
        if (index < 0 || index >= items.length) return;
        active = index;
        var item = items[index];
        stageImg.src = item.full;
        stageLink.href = item.zoom || item.full;
        thumbButtons.forEach(function (btn, i) {
            btn.classList.toggle('is-active', i === index);
            btn.setAttribute('aria-selected', i === index ? 'true' : 'false');
        });
    }

    items.forEach(function (item, index) {
        var btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'doro-gallery__thumb' + (index === 0 ? ' is-active' : '');
        btn.setAttribute('role', 'option');
        btn.setAttribute('aria-selected', index === 0 ? 'true' : 'false');
        btn.setAttribute('aria-label', 'Ver imagen ' + (index + 1));

        var tImg = document.createElement('img');
        tImg.src = item.thumb;
        tImg.alt = '';
        tImg.loading = 'lazy';
        tImg.decoding = 'async';
        btn.appendChild(tImg);

        btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            setActive(index);
        });

        thumbs.appendChild(btn);
        thumbButtons.push(btn);
    });

    function isHorizontal() {
        return window.matchMedia('(max-width: 768px)').matches;
    }

    function updateNav() {
        var needsNav = isHorizontal()
            ? thumbs.scrollWidth > thumbs.clientWidth + 4
            : thumbs.scrollHeight > thumbs.clientHeight + 4;
        if (!needsNav) {
            btnPrev.hidden = true;
            btnNext.hidden = true;
            return;
        }
        btnPrev.hidden = false;
        btnNext.hidden = false;
        if (isHorizontal()) {
            btnPrev.disabled = thumbs.scrollLeft <= 2;
            btnNext.disabled = thumbs.scrollLeft + thumbs.clientWidth >= thumbs.scrollWidth - 2;
        } else {
            btnPrev.disabled = thumbs.scrollTop <= 2;
            btnNext.disabled = thumbs.scrollTop + thumbs.clientHeight >= thumbs.scrollHeight - 2;
        }
    }

    btnPrev.addEventListener('click', function (e) {
        e.preventDefault();
        if (isHorizontal()) thumbs.scrollBy({ left: -80, behavior: 'smooth' });
        else thumbs.scrollBy({ top: -88, behavior: 'smooth' });
    });
    btnNext.addEventListener('click', function (e) {
        e.preventDefault();
        if (isHorizontal()) thumbs.scrollBy({ left: 80, behavior: 'smooth' });
        else thumbs.scrollBy({ top: 88, behavior: 'smooth' });
    });
    thumbs.addEventListener('scroll', updateNav, { passive: true });
    window.addEventListener('resize', updateNav);

    rail.appendChild(btnPrev);
    rail.appendChild(thumbs);
    rail.appendChild(btnNext);

    gallery.insertBefore(rail, gallery.firstChild);
    gallery.insertBefore(stage, rail.nextSibling);

    // Abrir lightbox WC / Photoswipe si existe el trigger original.
    stageLink.addEventListener('click', function (e) {
        var trigger = gallery.querySelector('.woocommerce-product-gallery__trigger');
        if (trigger) {
            e.preventDefault();
            // Activar la figura correspondiente y disparar zoom WC.
            items.forEach(function (item, i) {
                item.fig.classList.toggle('flex-active-slide', i === active);
            });
            trigger.click();
        }
    });

    updateNav();
    requestAnimationFrame(updateNav);
    setActive(0);
}

function initVisualSearchSlot() {
    var wraps = Array.prototype.slice.call(document.querySelectorAll('[data-visual-search]'));
    if (!wraps.length) return;

    wraps.forEach(function (wrap) {
        var trigger = wrap.querySelector('[data-visual-search-trigger]');
        var input = wrap.querySelector('[data-visual-search-input]');
        if (!trigger || !input) return;

        trigger.addEventListener('click', function (e) {
            e.preventDefault();
            input.click();
        });

        input.addEventListener('change', function () {
            var file = input.files && input.files[0];
            if (!file) return;

            document.dispatchEvent(new CustomEvent('doroshopping:visual-search', {
                detail: {
                    file: file,
                    name: file.name,
                    type: file.type,
                    size: file.size
                }
            }));

            input.value = '';
        });
    });
}

/**
 * Wishlist: corazon en cards / producto. Sync via AJAX (WP) o localStorage (preview).
 */
function initWishlist() {
    var buttons = Array.prototype.slice.call(document.querySelectorAll('[data-wishlist-toggle]'));
    if (!buttons.length) return;

    var cfg = window.doroshoppingWishlist || {};
    var PREVIEW_KEY = 'doroshopping_wishlist_preview';
    var ids = Array.isArray(cfg.ids) ? cfg.ids.map(Number) : [];

    function readPreviewIds() {
        try {
            var raw = localStorage.getItem(PREVIEW_KEY);
            var parsed = raw ? JSON.parse(raw) : [];
            return Array.isArray(parsed) ? parsed.map(Number) : [];
        } catch (e) {
            return [];
        }
    }

    function writePreviewIds(list) {
        localStorage.setItem(PREVIEW_KEY, JSON.stringify(list));
    }

    if (!cfg.ajaxUrl || !cfg.nonce) {
        ids = readPreviewIds();
    }

    function isActive(id) {
        return ids.indexOf(Number(id)) !== -1;
    }

    function syncButtons() {
        buttons = Array.prototype.slice.call(document.querySelectorAll('[data-wishlist-toggle]'));
        buttons.forEach(function (btn) {
            var id = Number(btn.getAttribute('data-product-id'));
            var on = isActive(id);
            btn.classList.toggle('is-active', on);
            btn.setAttribute('aria-pressed', on ? 'true' : 'false');
        });
    }

    function applyLocalToggle(id) {
        var num = Number(id);
        var idx = ids.indexOf(num);
        if (idx === -1) {
            ids.push(num);
            return true;
        }
        ids.splice(idx, 1);
        return false;
    }

    function toggle(btn) {
        var id = btn.getAttribute('data-product-id');
        if (!id) return;

        btn.disabled = true;

        if (!cfg.ajaxUrl || !cfg.nonce) {
            applyLocalToggle(id);
            writePreviewIds(ids);
            syncButtons();
            btn.disabled = false;
            document.dispatchEvent(new CustomEvent('doroshopping:wishlist-updated', { detail: { ids: ids } }));
            return;
        }

        var body = new FormData();
        body.append('action', 'doroshopping_toggle_wishlist');
        body.append('nonce', cfg.nonce);
        body.append('product_id', id);

        fetch(cfg.ajaxUrl, { method: 'POST', credentials: 'same-origin', body: body })
            .then(function (res) { return res.json(); })
            .then(function (json) {
                if (!json || !json.success) throw new Error('wishlist');
                ids = (json.data.ids || []).map(Number);
                syncButtons();
                document.dispatchEvent(new CustomEvent('doroshopping:wishlist-updated', { detail: { ids: ids, added: json.data.added } }));
            })
            .catch(function () { /* silent */ })
            .finally(function () { btn.disabled = false; });
    }

    document.body.addEventListener('click', function (e) {
        var btn = e.target.closest('[data-wishlist-toggle]');
        if (!btn) return;
        e.preventDefault();
        e.stopPropagation();
        toggle(btn);
    });

    syncButtons();
}

/**
 * Estimacion de envio BigBuy (producto + carrito), acoplada al pais/CP del header.
 */
function initBigBuyShipping() {
    var cfg = window.doroshoppingShipping || null;
    var roots = Array.prototype.slice.call(document.querySelectorAll('[data-doro-shipping]'));
    if (!roots.length) return;

    var FALLBACKS = (cfg && cfg.fallbacks) ? cfg.fallbacks : {
        DE: { carrier: 'DHL / DPD', range: '3 - 5', cost: '8.90 EUR' },
        GB: { carrier: 'Royal Mail / DHL', range: '5 - 8', cost: '12.90 GBP' },
        UK: { carrier: 'Royal Mail / DHL', range: '5 - 8', cost: '12.90 GBP' },
        ES: { carrier: 'Correos Express / SEUR', range: '2 - 4', cost: '6.90 EUR' },
        FR: { carrier: 'Colissimo / DHL', range: '3 - 5', cost: '7.90 EUR' },
        IT: { carrier: 'BRT / DHL', range: '4 - 6', cost: '8.90 EUR' },
        PT: { carrier: 'CTT / DHL', range: '3 - 5', cost: '6.90 EUR' },
        CH: { carrier: 'Swiss Post / DHL', range: '5 - 8', cost: '14.90 CHF' }
    };

    function formatEta(range) {
        var tpl = (cfg && cfg.i18n && cfg.i18n.etaDays) || '%s dias habiles';
        return String(tpl).replace('%s', range || '');
    }

    function fallbackNote() {
        return (cfg && cfg.i18n && cfg.i18n.note) || 'Coste estimado segun destino. El importe final puede variar ligeramente en checkout.';
    }

    function readCookie(name) {
        var parts = (document.cookie || '').split(';');
        for (var i = 0; i < parts.length; i++) {
            var part = parts[i].trim();
            if (part.indexOf(name + '=') === 0) {
                return decodeURIComponent(part.slice(name.length + 1));
            }
        }
        return '';
    }

    function countryCode() {
        var fromCfg = cfg && cfg.country ? String(cfg.country).toUpperCase() : '';
        var fromCookie = (readCookie('doroshopping_country') || '').toUpperCase();
        var code = fromCfg || fromCookie || 'ES';
        if (code === 'UK') code = 'GB';
        return code.length >= 2 ? code.slice(0, 2) : 'ES';
    }

    function postcode() {
        if (cfg && cfg.postcode) return String(cfg.postcode);
        return readCookie('doroshopping_postcode') || '';
    }

    var saveHintTimer = null;
    function persistShippingHint(country, pc) {
        if (!cfg || !cfg.ajaxUrl || !cfg.prefsNonce) return;
        clearTimeout(saveHintTimer);
        saveHintTimer = setTimeout(function () {
            var body = new FormData();
            body.append('action', 'doroshopping_save_shipping_hint');
            body.append('nonce', cfg.prefsNonce);
            if (country) body.append('country', country);
            if (pc !== undefined && pc !== null) body.append('postcode', pc);
            fetch(cfg.ajaxUrl, { method: 'POST', body: body, credentials: 'same-origin' }).catch(function () {});
        }, 400);
    }

    function countryLabel(code) {
        var labels = (cfg && cfg.labels) || {};
        return labels[code] || labels.ES || code;
    }

    function fallback(code) {
        var data = FALLBACKS[code] || FALLBACKS.ES;
        var range = data.range || data.time || '';
        return {
            success: true,
            source: 'fallback',
            carrier: data.carrier,
            time: data.range ? formatEta(data.range) : range,
            cost: data.cost,
            note: fallbackNote(),
            country: code
        };
    }

    function paint(root, data, code) {
        if (!root || !data) return;
        var dest = root.querySelector('[data-shipping-destination]');
        var carrier = root.querySelector('[data-shipping-carrier]');
        var eta = root.querySelector('[data-shipping-eta]');
        var cost = root.querySelector('[data-shipping-cost]');
        var note = root.querySelector('[data-shipping-note]');

        if (dest) dest.textContent = countryLabel(code);
        if (carrier) carrier.textContent = data.carrier || '-';
        if (eta) eta.textContent = data.time || '-';
        if (cost) cost.textContent = data.cost || '-';
        if (note) note.textContent = data.note || '';

        root.setAttribute('data-shipping-ready', data.success ? '1' : '0');
        root.hidden = false;
        root.classList.remove('is-loading');
    }

    function setLoading(root, on) {
        root.classList.toggle('is-loading', !!on);
        if (on) {
            var carrier = root.querySelector('[data-shipping-carrier]');
            var eta = root.querySelector('[data-shipping-eta]');
            var cost = root.querySelector('[data-shipping-cost]');
            var msg = (cfg && cfg.i18n && cfg.i18n.loading) || 'Calculando envio...';
            if (carrier) carrier.textContent = msg;
            if (eta) eta.textContent = '...';
            if (cost) cost.textContent = '...';
            root.hidden = false;
        }
    }

    function buildPayload(root) {
        var code = countryCode();
        var qtyEl = document.querySelector('.doro-buybox form.cart input.qty, .doro-buybox .quantity .qty');
        var qty = qtyEl ? Math.max(1, parseInt(qtyEl.value || qtyEl.textContent, 10) || 1) : 1;
        var buybox = document.querySelector('[data-doro-buybox]');
        var productId = buybox ? parseInt(buybox.getAttribute('data-product-id') || '0', 10) : 0;
        var context = root.getAttribute('data-shipping-context') || (productId ? 'product' : 'cart');

        var payload = {
            country: code,
            postcode: postcode()
        };

        if (context === 'cart' && cfg && Array.isArray(cfg.cartLines) && cfg.cartLines.length) {
            payload.products = cfg.cartLines;
        } else if (productId > 0) {
            payload.product_id = productId;
            payload.quantity = qty;
        } else if (cfg && Array.isArray(cfg.cartLines) && cfg.cartLines.length) {
            payload.products = cfg.cartLines;
        } else {
            payload.products = [{ reference: 'PREVIEW', sku: 'PREVIEW', quantity: 1 }];
        }

        return { payload: payload, code: code };
    }

    function mockFetch(payload, code) {
        return Promise.resolve(fallback(code));
    }

    function liveFetch(payload) {
        if (!cfg || !cfg.restUrl) {
            return Promise.resolve(fallback(payload.country));
        }
        return fetch(cfg.restUrl, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
                'X-WP-Nonce': (cfg && cfg.nonce) ? cfg.nonce : ''
            },
            body: JSON.stringify(payload)
        })
            .then(function (res) { return res.json(); })
            .then(function (json) {
                if (!json || json.success === false) {
                    return fallback(payload.country);
                }
                return json;
            })
            .catch(function () {
                return fallback(payload.country);
            });
    }

    function refresh() {
        roots.forEach(function (root) {
            var built = buildPayload(root);
            setLoading(root, true);
            var runner = (cfg && cfg.preview) ? mockFetch : liveFetch;
            runner(built.payload, built.code).then(function (data) {
                paint(root, data, built.code);
            });
        });
    }

    document.addEventListener('change', function (e) {
        var t = e.target;
        if (!t) return;
        if (t.id === 'locale-ubicacion' || t.name === 'ubicacion' || t.id === 'shipping-pais' || t.name === 'pais') {
            var val = String(t.value || '').toUpperCase();
            if (val.length >= 2) {
                if (cfg) cfg.country = val.slice(0, 2);
                persistShippingHint(val.slice(0, 2), undefined);
                refresh();
            }
        }
        if (t.id === 'shipping-cp' || t.name === 'codigo_postal') {
            if (cfg) cfg.postcode = t.value || '';
            persistShippingHint(undefined, t.value || '');
            refresh();
        }
    });

    document.addEventListener('click', function (e) {
        var select = e.target && e.target.closest ? e.target.closest('[data-locale-select="ubicacion"]') : null;
        var opt = e.target && e.target.closest ? e.target.closest('.header-locale-select__option') : null;
        if (!select || !opt || !select.contains(opt)) return;
        var val = String(opt.getAttribute('data-value') || '').toUpperCase();
        if (val.length < 2) return;
        if (cfg) cfg.country = val.slice(0, 2);
        persistShippingHint(val.slice(0, 2), undefined);
        setTimeout(refresh, 30);
    });

    var qtyInput = document.querySelector('.doro-buybox form.cart input.qty');
    if (qtyInput) {
        qtyInput.addEventListener('change', refresh);
    }

    refresh();
    window.doroshoppingRefreshShipping = refresh;
}

function initLegalPageToc() {
    var nav = document.querySelector('[data-doro-toc]');
    var list = document.querySelector('[data-doro-toc-list]');
    var content = document.querySelector('[data-doro-page-content]');
    if (!nav || !list || !content) return;

    var headings = content.querySelectorAll('h2');
    if (!headings.length) return;

    list.innerHTML = '';
    headings.forEach(function (h, i) {
        var id = h.id;
        if (!id) {
            id = 'doro-section-' + (i + 1);
            h.id = id;
        }
        var li = document.createElement('li');
        var a = document.createElement('a');
        a.href = '#' + id;
        a.textContent = h.textContent || ('Sección ' + (i + 1));
        li.appendChild(a);
        list.appendChild(li);
    });
    nav.hidden = false;

    var links = list.querySelectorAll('a');
    function onScroll() {
        var active = null;
        headings.forEach(function (h) {
            if (h.getBoundingClientRect().top <= 130) active = h;
        });
        links.forEach(function (a) {
            var match = active && a.getAttribute('href') === '#' + active.id;
            a.classList.toggle('is-active', !!match);
        });
    }
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
}

function initProductMoreLoadMore() {
    var section = document.querySelector('[data-product-more]');
    if (!section) return;

    var grid = section.querySelector('[data-product-more-grid]');
    var wrap = section.querySelector('[data-product-more-wrap]');
    var btn = section.querySelector('[data-product-more-btn]');
    if (!grid || !wrap) return;

    var cfg = window.doroshoppingProductMore || {};
    var ajaxUrl = cfg.ajaxUrl || '';
    var nonce = cfg.nonce || '';
    var i18n = cfg.i18n || {};
    var loading = false;

    function switchToShop() {
        var shopUrl = section.getAttribute('data-shop-url') || '/';
        wrap.innerHTML = '';
        var link = document.createElement('a');
        link.className = 'doro-load-more__btn';
        link.href = shopUrl;
        link.textContent = i18n.viewShop || 'Ver más en la tienda';
        wrap.appendChild(link);
    }

    if (!btn) return;

    btn.addEventListener('click', function () {
        if (loading || !ajaxUrl) return;

        var page = parseInt(section.getAttribute('data-page') || '1', 10) + 1;
        var shown = parseInt(section.getAttribute('data-shown') || '0', 10);
        var max = parseInt(section.getAttribute('data-max') || '240', 10);
        var batch = parseInt(section.getAttribute('data-batch') || '30', 10);
        var exclude = section.getAttribute('data-exclude') || '0';

        if (shown >= max) {
            switchToShop();
            return;
        }

        loading = true;
        btn.disabled = true;
        btn.classList.add('is-loading');
        btn.textContent = i18n.loading || 'Cargando…';

        var body = new FormData();
        body.append('action', 'doroshopping_product_more_load');
        body.append('nonce', nonce);
        body.append('page', String(page));
        body.append('shown', String(shown));
        body.append('max', String(max));
        body.append('batch', String(batch));
        body.append('exclude', String(exclude));

        fetch(ajaxUrl, { method: 'POST', credentials: 'same-origin', body: body })
            .then(function (res) { return res.json(); })
            .then(function (json) {
                if (!json || !json.success || !json.data) {
                    throw new Error('bad response');
                }
                var data = json.data;
                if (data.html) {
                    var tmp = document.createElement('div');
                    tmp.innerHTML = data.html;
                    while (tmp.firstChild) {
                        grid.appendChild(tmp.firstChild);
                    }
                    if (window.jQuery) {
                        window.jQuery(document.body).trigger('doro_products_loaded');
                    }
                }

                section.setAttribute('data-page', String(data.page || page));
                section.setAttribute('data-shown', String(data.shown != null ? data.shown : shown));

                if (data.go_to_shop || data.done || !data.count) {
                    switchToShop();
                    return;
                }

                btn.disabled = false;
                btn.classList.remove('is-loading');
                btn.textContent = i18n.viewMore || 'Ver más';
            })
            .catch(function () {
                btn.disabled = false;
                btn.classList.remove('is-loading');
                btn.textContent = i18n.viewMore || 'Ver más';
            })
            .finally(function () {
                loading = false;
            });
    });
}

function initProductShare() {
    document.querySelectorAll('[data-share-product]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var url = btn.getAttribute('data-share-url') || window.location.href;
            var title = btn.getAttribute('data-share-title') || document.title;
            if (navigator.share) {
                navigator.share({ title: title, url: url }).catch(function () {});
                return;
            }
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(url).then(function () {
                    btn.classList.add('is-copied');
                    var prev = btn.innerHTML;
                    btn.setAttribute('data-prev-html', prev);
                    btn.textContent = 'Enlace copiado';
                    setTimeout(function () {
                        var old = btn.getAttribute('data-prev-html');
                        if (old) btn.innerHTML = old;
                        btn.classList.remove('is-copied');
                    }, 1600);
                }).catch(function () {
                    window.prompt('Copia el enlace:', url);
                });
                return;
            }
            window.prompt('Copia el enlace:', url);
        });
    });
}

function initSecurePaymentsModal() {
    var modal = document.querySelector('[data-secure-payments-modal]');
    if (!modal) return;

    var openers = document.querySelectorAll('[data-secure-payments-open]');
    if (!openers.length) return;

    var lastFocus = null;

    function openModal() {
        lastFocus = document.activeElement;
        modal.hidden = false;
        document.body.classList.add('doro-modal-open');
        var closeBtn = modal.querySelector('[data-secure-payments-close]');
        if (closeBtn) closeBtn.focus();
    }

    function closeModal() {
        modal.hidden = true;
        document.body.classList.remove('doro-modal-open');
        if (lastFocus && typeof lastFocus.focus === 'function') lastFocus.focus();
    }

    openers.forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            openModal();
        });
    });

    modal.querySelectorAll('[data-secure-payments-close]').forEach(function (el) {
        el.addEventListener('click', function (e) {
            e.preventDefault();
            closeModal();
        });
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !modal.hidden) closeModal();
    });
}

/**
 * Al vaciar el carrito, el AJAX de WC + AGA (querySelectorAll vacío) deja la página en blanco.
 * El último producto se elimina con navegación completa (sin AJAX).
 */
function initCartPageEmptyReload() {
    var onCartPage = document.body.classList.contains('woocommerce-cart')
        || document.body.classList.contains('doro-cart-page');
    if (!onCartPage) return;

    var recovering = false;

    function cartUrl() {
        if (window.wc_cart_params && window.wc_cart_params.cart_url) {
            return window.wc_cart_params.cart_url;
        }
        return window.location.pathname;
    }

    function hasFullEmptyLayout() {
        return !!(document.querySelector('.doro-cesta__aside') && document.querySelector('.doro-cesta-empty'));
    }

    function hasCartItems() {
        return !!document.querySelector('.doro-cesta-item, .woocommerce-cart-form__cart-item, tr.cart_item');
    }

    function unblockCart() {
        if (typeof jQuery === 'undefined') return;
        try {
            jQuery('.woocommerce, .woocommerce-cart-form, .doro-cesta').unblock();
        } catch (e) { /* ignore */ }
    }

    function recoverEmpty() {
        if (recovering || hasCartItems() || hasFullEmptyLayout()) {
            unblockCart();
            return;
        }
        recovering = true;
        unblockCart();
        window.location.replace(cartUrl());
    }

    // Último ítem: navegación real al enlace remove (evita AJAX + AGA).
    document.addEventListener('click', function (e) {
        var btn = e.target.closest('a.doro-cesta-item__remove-btn, .product-remove a.remove, a.remove');
        if (!btn || !btn.getAttribute('href')) return;
        if (!btn.closest('.doro-cesta, .woocommerce-cart-form, form.woocommerce-cart-form, .woocommerce')) return;

        var items = document.querySelectorAll('.doro-cesta-item, .woocommerce-cart-form__cart-item, tr.cart_item');
        if (items.length > 1) return;

        e.preventDefault();
        e.stopImmediatePropagation();
        window.location.href = btn.href;
    }, true);

    document.body.addEventListener('removed_from_cart', function () {
        setTimeout(recoverEmpty, 100);
    });

    if (typeof jQuery !== 'undefined') {
        jQuery(document.body).on('updated_wc_div wc_fragments_refreshed updated_cart_totals wc_cart_emptied', function () {
            setTimeout(recoverEmpty, 100);
        });
    }
}

/**
 * Aviso suave de país detectado por IP (sin GPS).
 * La detección corre en AJAX para no retrasar el HTML.
 */
function initGeoSuggestBanner() {
    var cfg = window.doroshoppingGeo || {};
    if (!cfg.enabled || !cfg.probe) return;

    try {
        if (window.sessionStorage && sessionStorage.getItem('doro_geo_probed') === '1') {
            return;
        }
    } catch (e) { /* private mode */ }

    function markProbed() {
        try {
            if (window.sessionStorage) {
                sessionStorage.setItem('doro_geo_probed', '1');
            }
        } catch (err) { /* ignore */ }
    }

    function post(action, extra) {
        var body = new FormData();
        body.append('action', action);
        body.append('nonce', cfg.nonce || '');
        if (extra) {
            Object.keys(extra).forEach(function (key) {
                body.append(key, extra[key]);
            });
        }
        return fetch(cfg.ajaxUrl || '/wp-admin/admin-ajax.php', {
            method: 'POST',
            credentials: 'same-origin',
            body: body
        }).then(function (res) {
            return res.json();
        });
    }

    function openLocaleDropdown() {
        var wrap = document.querySelector('.site-header__dropdown-wrap[data-dropdown="locale"]');
        var btn = wrap ? wrap.querySelector('.site-header__utility-btn') : null;
        if (btn) {
            btn.click();
            return;
        }
        var header = document.querySelector('.site-header');
        if (header && typeof header.scrollIntoView === 'function') {
            header.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    function bindBanner(banner) {
        if (!banner) return;

        banner.hidden = false;

        banner.addEventListener('click', function (e) {
            var accept = e.target.closest('[data-geo-accept]');
            var dismiss = e.target.closest('[data-geo-dismiss]');
            var change = e.target.closest('[data-geo-change]');

            if (accept) {
                e.preventDefault();
                accept.disabled = true;
                post('doroshopping_geo_accept', {
                    country: banner.getAttribute('data-geo-country') || ''
                }).then(function (json) {
                    markProbed();
                    if (json && json.success && json.data && json.data.redirect) {
                        window.location.href = json.data.redirect;
                        return;
                    }
                    banner.hidden = true;
                }).catch(function () {
                    accept.disabled = false;
                });
                return;
            }

            if (change) {
                e.preventDefault();
                post('doroshopping_geo_dismiss').finally(function () {
                    markProbed();
                    banner.hidden = true;
                    openLocaleDropdown();
                });
                return;
            }

            if (dismiss) {
                e.preventDefault();
                post('doroshopping_geo_dismiss').finally(function () {
                    markProbed();
                    banner.hidden = true;
                });
            }
        });
    }

    window.setTimeout(function () {
        post('doroshopping_geo_probe').then(function (json) {
            markProbed();
            if (!json || !json.success || !json.data || !json.data.suggest || !json.data.html) {
                return;
            }
            var wrap = document.createElement('div');
            wrap.innerHTML = String(json.data.html).trim();
            var banner = wrap.querySelector('[data-geo-banner]') || wrap.firstElementChild;
            if (!banner) return;
            document.body.appendChild(banner);
            bindBanner(banner);
        }).catch(function () {
            markProbed();
        });
    }, 900);
}
