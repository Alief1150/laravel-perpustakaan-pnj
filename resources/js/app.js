document.documentElement.classList.add('js');

const storageKey = 'pnj-theme';
const root = document.documentElement;

function applyTheme(theme) {
    root.classList.toggle('dark', theme === 'dark');
    root.dataset.theme = theme;

    document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
        const lightIcon = button.querySelector('.theme-icon-light');
        const darkIcon = button.querySelector('.theme-icon-dark');

        if (lightIcon && darkIcon) {
            lightIcon.classList.toggle('hidden', theme === 'dark');
            darkIcon.classList.toggle('hidden', theme !== 'dark');
        }
    });
}

const savedTheme = localStorage.getItem(storageKey);
const preferredTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';

applyTheme(savedTheme || preferredTheme);

document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
    button.addEventListener('click', () => {
        const nextTheme = root.classList.contains('dark') ? 'light' : 'dark';

        localStorage.setItem(storageKey, nextTheme);
        applyTheme(nextTheme);
    });
});

const mobileMenu = document.querySelector('[data-mobile-menu]');

if (mobileMenu) {
    const menuButton = mobileMenu.querySelector('[data-mobile-menu-button]');
    const panel = mobileMenu.querySelector('[data-mobile-menu-panel]');
    const menuLinks = panel ? panel.querySelectorAll('a, button') : [];

    const setOpen = (isOpen) => {
        if (!menuButton || !panel) {
            return;
        }

        menuButton.setAttribute('aria-expanded', String(isOpen));
        panel.classList.toggle('pointer-events-none', !isOpen);
        panel.classList.toggle('opacity-0', !isOpen);
        panel.classList.toggle('scale-95', !isOpen);
        panel.classList.toggle('translate-y-2', !isOpen);
        panel.classList.toggle('pointer-events-auto', isOpen);
        panel.classList.toggle('opacity-100', isOpen);
        panel.classList.toggle('scale-100', isOpen);
        panel.classList.toggle('translate-y-0', isOpen);
    };

    setOpen(false);

    menuButton?.addEventListener('click', (event) => {
        event.stopPropagation();
        const isOpen = menuButton.getAttribute('aria-expanded') === 'true';

        setOpen(!isOpen);
    });

    menuLinks.forEach((link) => {
        link.addEventListener('click', () => setOpen(false));
    });

    document.addEventListener('click', (event) => {
        if (!mobileMenu.contains(event.target)) {
            setOpen(false);
        }
    });
}

document.querySelectorAll('[data-carousel-control]').forEach((button) => {
    button.addEventListener('click', () => {
        const target = document.querySelector(button.dataset.carouselTarget || '');

        if (!target) {
            return;
        }

        const event = new CustomEvent('pnj-carousel-step', {
            detail: { direction: button.dataset.carouselControl === 'next' ? 1 : -1 },
        });

        target.dispatchEvent(event);
    });
});

document.querySelectorAll('[data-featured-carousel]').forEach((carousel) => {
    const originals = Array.from(carousel.querySelectorAll('[data-carousel-slide]'));
    const dotsContainer = document.querySelector('[data-carousel-dots]');

    if (originals.length === 0) {
        return;
    }

    originals.forEach((slide) => {
        carousel.appendChild(slide.cloneNode(true));
    });

    const slides = Array.from(carousel.querySelectorAll('[data-carousel-slide]'));
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    let running = !reduceMotion;
    let lastTs = 0;
    let position = 0;
    let cycleWidth = 1;
    let speed = 22;
    let itemSpan = 1;
    let activeIndex = 0;

    const dots = [];

    if (dotsContainer) {
        dotsContainer.innerHTML = '';

        originals.forEach((_, index) => {
            const dot = document.createElement('button');
            dot.type = 'button';
            dot.className = 'pnj-carousel-dot';
            dot.setAttribute('aria-label', `Buka koleksi ${index + 1}`);
            dot.setAttribute('aria-current', index === 0 ? 'true' : 'false');

            dot.addEventListener('click', () => {
                position = itemSpan * index;
                running = !reduceMotion;
                paint();
            });

            dotsContainer.appendChild(dot);
            dots.push(dot);
        });
    }

    const measure = () => {
        const first = originals[0];
        const last = originals[originals.length - 1];
        const second = originals[1];

        if (!first || !last) {
            return;
        }

        cycleWidth = Math.max(last.offsetLeft + last.offsetWidth - first.offsetLeft, 1);
        itemSpan = Math.max((second?.offsetLeft ?? first.offsetWidth) - first.offsetLeft, first.offsetWidth, 1);

        const slideWidth = first.getBoundingClientRect().width;
        speed = window.innerWidth < 640 ? 16 : slideWidth < 260 ? 18 : 22;
    };

    const syncDots = () => {
        if (dots.length === 0) {
            return;
        }

        const normalized = ((position % cycleWidth) + cycleWidth) % cycleWidth;
        const nextIndex = Math.min(originals.length - 1, Math.floor((normalized + itemSpan * 0.5) / itemSpan));

        if (nextIndex === activeIndex) {
            return;
        }

        activeIndex = nextIndex;

        dots.forEach((dot, index) => {
            dot.setAttribute('aria-current', String(index === activeIndex));
        });
    };

    const paint = () => {
        carousel.style.transform = `translate3d(${-position}px, 0, 0)`;

        syncDots();
    };

    const loop = (ts) => {
        if (!running) {
            lastTs = ts;
            window.requestAnimationFrame(loop);
            return;
        }

        if (!lastTs) {
            lastTs = ts;
        }

        const delta = ts - lastTs;
        lastTs = ts;

        position += (delta / 1000) * speed;

        if (position >= cycleWidth) {
            position -= cycleWidth;
        }

        paint();
        window.requestAnimationFrame(loop);
    };

    const step = (direction = 1) => {
        position += direction * itemSpan;

        if (position < 0) {
            position += cycleWidth;
        }

        if (position >= cycleWidth) {
            position -= cycleWidth;
        }

        paint();
    };

    const restart = () => {
        running = !reduceMotion;
    };

    carousel.addEventListener('pnj-carousel-step', (event) => {
        step(event.detail?.direction || 1);
        restart();
    });

    carousel.addEventListener('mouseenter', () => {
        running = false;
    });

    carousel.addEventListener('mouseleave', restart);
    carousel.addEventListener('touchstart', () => { running = false; }, { passive: true });
    carousel.addEventListener('touchend', restart, { passive: true });

    const onResize = () => {
        measure();
        paint();
    };

    window.addEventListener('resize', onResize);

    measure();
    paint();
    window.requestAnimationFrame(loop);
});
