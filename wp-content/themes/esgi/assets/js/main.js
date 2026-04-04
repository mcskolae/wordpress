(() => {
    'use strict';

    const toggle = document.querySelector('.menu-toggle');
    const nav = document.querySelector('.main-navigation');

    if (toggle && nav) {
        toggle.addEventListener('click', () => {
            const open = nav.classList.toggle('is-open');
            toggle.setAttribute('aria-expanded', String(open));
        });

        document.addEventListener('click', (e) => {
            if (!nav.contains(e.target) && !toggle.contains(e.target)) {
                nav.classList.remove('is-open');
                toggle.setAttribute('aria-expanded', 'false');
            }
        });
    }

    const updateCartCount = () => {
        const countEl = document.querySelector('.cart-count');
        if (!countEl || typeof esgiData === 'undefined') return;

        fetch(`${esgiData.restUrl}esgi/v1/cart-count`)
            .then(res => res.json())
            .then(data => {
                if (data && typeof data.count !== 'undefined') {
                    countEl.textContent = data.count;
                }
            })
            .catch(() => {});
    };

    document.body.addEventListener('wc_fragments_refreshed', updateCartCount);
    document.body.addEventListener('wc_fragment_refresh', updateCartCount);
    document.body.addEventListener('added_to_cart', updateCartCount);

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', (e) => {
            const target = document.querySelector(anchor.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
})();
