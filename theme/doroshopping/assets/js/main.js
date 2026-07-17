document.addEventListener('DOMContentLoaded', function () {
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
});
