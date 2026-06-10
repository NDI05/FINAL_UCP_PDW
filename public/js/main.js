(function () {
    'use strict';

    class NDIAnimator {
        constructor() {
            this.lenis = null;
            this.scrollVelocity = 0;
            this.marqueePos = 0;
            this.marqueeRef = null;
            this.navRef = null;
            this.init();
        }

        init() {
            this.initLenis();
            this.initReveals();
            this.initNavbar();
            this.initMarquee();
            this.initParallax();
        }

        initLenis() {
            var self = this;
            if (typeof Lenis === 'undefined') return;

            this.lenis = new Lenis({
                duration: 1.2,
                easing: function (t) {
                    return Math.min(1, 1.001 - Math.pow(2, -10 * t));
                },
                orientation: 'vertical',
                smoothWheel: true,
                wheelMultiplier: 1,
                touchMultiplier: 1.5,
            });

            this.lenis.on('scroll', function (e) {
                self.scrollVelocity = e.velocity;
                self.handleNavScroll(e);
                self.updateMarqueeSpeed(e.velocity);
            });

            function raf(time) {
                self.lenis.raf(time);
                requestAnimationFrame(raf);
            }
            requestAnimationFrame(raf);
        }

        initReveals() {
            var self = this;
            var els = document.querySelectorAll('[data-scroll-reveal]');
            if (!els.length) return;

            var observer = new IntersectionObserver(
                function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            if (entry.target.dataset.scrollReveal === 'up') {
                                entry.target.classList.add('reveal-up', 'revealed');
                            } else {
                                entry.target.classList.add('revealed');
                            }
                            observer.unobserve(entry.target);
                        }
                    });
                },
                { threshold: 0.08, rootMargin: '0px 0px -40px 0px' }
            );

            els.forEach(function (el) {
                observer.observe(el);
            });
        }

        initNavbar() {
            this.navRef = document.querySelector('[data-nav]');
        }

        handleNavScroll(e) {
            if (!this.navRef) return;

            if (e.velocity > 0.5 && e.scroll > 120) {
                this.navRef.classList.add('nav-hidden');
                this.navRef.classList.add('nav-solid');
            } else if (e.velocity < -0.3) {
                this.navRef.classList.remove('nav-hidden');
                if (e.scroll > 120) {
                    this.navRef.classList.add('nav-solid');
                } else {
                    this.navRef.classList.remove('nav-solid');
                }
            }

            if (e.scroll <= 120) {
                this.navRef.classList.remove('nav-solid');
            }
        }

        initMarquee() {
            var self = this;
            this.marqueeRef = document.querySelector('[data-marquee]');
            if (!this.marqueeRef) return;

            var clone = this.marqueeRef.cloneNode(true);
            this.marqueeRef.parentNode.appendChild(clone);

            var track1 = this.marqueeRef;
            var track2 = clone;
            this.marqueePos = 0;

            function animate() {
                var speed = 0.3 + Math.min(Math.abs(self.scrollVelocity) * 3, 8);
                self.marqueePos -= speed;

                var w = track1.offsetWidth;
                if (Math.abs(self.marqueePos) >= w) {
                    self.marqueePos = 0;
                }

                track1.style.transform = 'translateX(' + self.marqueePos + 'px)';
                track2.style.transform = 'translateX(' + (self.marqueePos + w) + 'px)';

                requestAnimationFrame(animate);
            }
            requestAnimationFrame(animate);
        }

        updateMarqueeSpeed(velocity) {}

        initParallax() {
            var containers = document.querySelectorAll('[data-parallax]');
            if (!containers.length) return;

            var observer = new IntersectionObserver(
                function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            var img = entry.target.querySelector('img');
                            if (!img) return;
                            var rect = entry.target.getBoundingClientRect();
                            var centerOffset =
                                rect.top + rect.height / 2 - window.innerHeight / 2;
                            var shift = Math.max(-25, Math.min(25, centerOffset * 0.06));
                            img.style.transform = 'translateY(' + shift + 'px) scale(1.05)';
                        }
                    });
                },
                { threshold: 0.1 }
            );

            containers.forEach(function (el) {
                observer.observe(el);
            });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            new NDIAnimator();
        });
    } else {
        new NDIAnimator();
    }
})();
