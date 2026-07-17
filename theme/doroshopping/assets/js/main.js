document.addEventListener('DOMContentLoaded', function () {
    initMegaMenu();
    initHeaderDropdowns();
    initHeroCarousel();
    initCategoryCarousels();
    initPromoParallax();
});

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
