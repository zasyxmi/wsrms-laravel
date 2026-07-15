import './bootstrap';

import Alpine from 'alpinejs';
import { gsap } from 'gsap';

const reducedMotionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');

window.gsap = gsap;

function initializeAlpine() {
    if (window.Alpine?.initialized) {
        return;
    }

    window.Alpine = Alpine;
    window.Alpine.initialized = true;
    Alpine.start();
}

function prefersReducedMotion() {
    return reducedMotionQuery.matches;
}

function initializeGsapAnimations() {
    if (prefersReducedMotion()) {
        return;
    }

    const page = document.querySelector('[data-gsap-page]');

    if (page) {
        gsap.from(page, {
            opacity: 0,
            y: 8,
            duration: 0.32,
            ease: 'power2.out',
        });
    }
}

function getAnimationVars(type) {
    const animations = {
        'fade-up': { from: { opacity: 0, y: 20 }, to: { opacity: 1, y: 0 } },
        'fade-in': { from: { opacity: 0 }, to: { opacity: 1 } },
        'slide-left': { from: { opacity: 0, x: 24 }, to: { opacity: 1, x: 0 } },
        'slide-right': { from: { opacity: 0, x: -24 }, to: { opacity: 1, x: 0 } },
        'scale-in': { from: { opacity: 0, scale: 0.97 }, to: { opacity: 1, scale: 1 } },
        hero: { from: { opacity: 0, y: 18 }, to: { opacity: 1, y: 0 } },
    };

    return animations[type] ?? animations['fade-up'];
}

function initializeScrollReveal() {
    if (prefersReducedMotion() || !('IntersectionObserver' in window)) {
        return;
    }

    const revealElements = document.querySelectorAll('[data-gsap]');

    if (!revealElements.length) {
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) {
                return;
            }

            const element = entry.target;
            const animation = getAnimationVars(element.dataset.gsap);
            const duration = Number(element.dataset.gsapDuration ?? 0.45);
            const delay = Number(element.dataset.gsapDelay ?? 0);

            gsap.fromTo(element, animation.from, {
                ...animation.to,
                duration,
                delay,
                ease: 'power2.out',
                clearProps: 'transform',
            });

            observer.unobserve(element);
        });
    }, {
        threshold: 0.16,
        rootMargin: '0px 0px -8% 0px',
    });

    revealElements.forEach((element) => observer.observe(element));
}

function initializeStaggerGroups() {
    if (prefersReducedMotion() || !('IntersectionObserver' in window)) {
        return;
    }

    const groups = document.querySelectorAll('[data-gsap-stagger]');

    if (!groups.length) {
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) {
                return;
            }

            const group = entry.target;
            const children = group.querySelectorAll('[data-gsap-item]');

            if (children.length) {
                gsap.fromTo(children, { opacity: 0, y: 16 }, {
                    opacity: 1,
                    y: 0,
                    duration: Number(group.dataset.gsapDuration ?? 0.42),
                    stagger: Number(group.dataset.gsapStagger ?? 0.08),
                    ease: 'power2.out',
                    clearProps: 'transform',
                });
            }

            observer.unobserve(group);
        });
    }, {
        threshold: 0.16,
        rootMargin: '0px 0px -8% 0px',
    });

    groups.forEach((group) => observer.observe(group));
}

function initializeCounters() {
    if (prefersReducedMotion()) {
        return;
    }

    const counters = document.querySelectorAll('[data-gsap-counter]');

    if (!counters.length || !('IntersectionObserver' in window)) {
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) {
                return;
            }

            const element = entry.target;
            const finalValue = Number(element.dataset.gsapCounter);

            if (!Number.isFinite(finalValue)) {
                observer.unobserve(element);
                return;
            }

            const prefix = element.dataset.gsapPrefix ?? '';
            const suffix = element.dataset.gsapSuffix ?? '';
            const decimals = Number(element.dataset.gsapDecimals ?? 0);
            const counter = { value: 0 };

            gsap.to(counter, {
                value: finalValue,
                duration: Number(element.dataset.gsapDuration ?? 0.75),
                ease: 'power2.out',
                onUpdate: () => {
                    element.textContent = `${prefix}${counter.value.toLocaleString('en-MY', {
                        minimumFractionDigits: decimals,
                        maximumFractionDigits: decimals,
                    })}${suffix}`;
                },
                onComplete: () => {
                    element.textContent = element.dataset.gsapFinal ?? element.textContent;
                },
            });

            observer.unobserve(element);
        });
    }, { threshold: 0.4 });

    counters.forEach((counter) => observer.observe(counter));
}

function initializeLoadingButtons() {
    document.querySelectorAll('form[data-loading-form]').forEach((form) => {
        form.addEventListener('submit', (event) => {
            if (event.defaultPrevented) {
                return;
            }

            const button = form.querySelector('[data-loading-button]');

            if (!button || button.disabled) {
                return;
            }

            const loadingText = button.dataset.loadingText;
            button.disabled = true;
            button.classList.add('ws-button-loading');

            if (loadingText) {
                button.dataset.originalText = button.textContent.trim();
                button.textContent = loadingText;
            }
        }, { once: true });
    });
}

function initializeSmoothScroll() {
    if (prefersReducedMotion()) {
        return;
    }

    document.querySelectorAll('a[href^="#"]:not([href="#"])').forEach((link) => {
        link.addEventListener('click', (event) => {
            const target = document.querySelector(link.getAttribute('href'));

            if (!target) {
                return;
            }

            event.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });
}

function initializeToastBehavior() {
    document.querySelectorAll('[data-ws-toast]').forEach((toast) => {
        const delay = Number(toast.dataset.wsToastDelay ?? 5000);

        if (delay <= 0) {
            return;
        }

        window.setTimeout(() => {
            toast.dispatchEvent(new CustomEvent('ws-toast-timeout', { bubbles: true }));
        }, delay);
    });
}

function initializeReducedMotion() {
    document.documentElement.classList.toggle('ws-reduced-motion', prefersReducedMotion());

    reducedMotionQuery.addEventListener?.('change', () => {
        document.documentElement.classList.toggle('ws-reduced-motion', prefersReducedMotion());
    });
}

initializeAlpine();

document.addEventListener('DOMContentLoaded', () => {
    initializeReducedMotion();
    initializeGsapAnimations();
    initializeScrollReveal();
    initializeStaggerGroups();
    initializeCounters();
    initializeLoadingButtons();
    initializeSmoothScroll();
    initializeToastBehavior();
});
