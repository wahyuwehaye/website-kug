import './bootstrap';

const ready = () => {
    initMobileNavigation();
    initDesktopNavigation();
    initHeroCarousel();
    initFaqAccordion();
    initChatbot();
    initCampusMap();
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', ready);
} else {
    ready();
}

function initMobileNavigation() {
    const toggle = document.querySelector('#mobile-menu-toggle');
    const menu = document.querySelector('#mobile-menu');

    if (!toggle || !menu) {
        return;
    }

    toggle.addEventListener('click', () => {
        menu.classList.toggle('hidden');
        toggle.classList.toggle('is-open');
    });

    menu.querySelectorAll('[data-collapse-trigger]').forEach((button) => {
        button.addEventListener('click', () => {
            const targetId = button.getAttribute('data-collapse-trigger');
            const target = targetId ? document.getElementById(targetId) : null;
            const icon = button.querySelector('[data-collapse-icon]');

            if (!target) {
                return;
            }

            const isOpen = target.classList.contains('hidden');
            menu.querySelectorAll('[data-collapse-target]').forEach((panel) => panel.classList.add('hidden'));
            menu.querySelectorAll('[data-collapse-icon]').forEach((icn) => icn.classList.remove('rotate-90'));

            if (isOpen) {
                target.classList.remove('hidden');
                target.setAttribute('data-collapse-target', 'open');
                icon?.classList.add('rotate-90');
            } else {
                target.classList.add('hidden');
                icon?.classList.remove('rotate-90');
            }
        });
    });
}

function initDesktopNavigation() {
    const navItems = document.querySelectorAll('[data-nav-item]');

    navItems.forEach((item) => {
        const menu = item.querySelector('[data-nav-menu]');
        let hoverTimeout;

        if (!menu) {
            return;
        }

        const openMenu = () => {
            clearTimeout(hoverTimeout);
            menu.classList.remove('pointer-events-none', 'opacity-0', '-translate-y-1');
        };

        const closeMenu = () => {
            hoverTimeout = window.setTimeout(() => {
                menu.classList.add('pointer-events-none', 'opacity-0', '-translate-y-1');
            }, 120);
        };

        ['mouseenter', 'focusin'].forEach((eventName) => {
            item.addEventListener(eventName, openMenu);
        });

        ['mouseleave', 'focusout'].forEach((eventName) => {
            item.addEventListener(eventName, closeMenu);
        });
    });
}

function initHeroCarousel() {
    const carousels = document.querySelectorAll('[data-carousel]');

    carousels.forEach((carousel) => {
        const slides = carousel.querySelectorAll('[data-carousel-slide]');
        const pagination = carousel.querySelectorAll('[data-carousel-dot]');
        const nextButton = carousel.querySelector('[data-carousel-next]');
        const prevButton = carousel.querySelector('[data-carousel-prev]');
        const progress = carousel.querySelector('[data-carousel-progress]');
        let index = 0;
        let intervalId;

        if (!slides.length) {
            return;
        }

        const activate = (newIndex) => {
            index = newIndex;
            slides.forEach((slide, slideIndex) => {
                slide.classList.toggle('is-active', slideIndex === index);
            });
            pagination.forEach((dot, dotIndex) => {
                dot.classList.toggle('bg-red-600', dotIndex === index);
                dot.classList.toggle('bg-slate-300', dotIndex !== index);
            });

            if (progress) {
                const bar = progress.querySelector('.hero-progress-bar');
                const clone = bar?.cloneNode(true);
                if (bar && clone) {
                    bar.parentNode?.replaceChild(clone, bar);
                }
            }
        };

        const next = () => activate((index + 1) % slides.length);
        const prev = () => activate((index - 1 + slides.length) % slides.length);

        const startAutoPlay = () => {
            stopAutoPlay();
            intervalId = window.setInterval(next, 8000);
        };

        const stopAutoPlay = () => {
            if (intervalId) {
                window.clearInterval(intervalId);
            }
        };

        pagination.forEach((dot, dotIndex) => {
            dot.addEventListener('click', () => {
                activate(dotIndex);
                startAutoPlay();
            });
        });

        nextButton?.addEventListener('click', () => {
            next();
            startAutoPlay();
        });

        prevButton?.addEventListener('click', () => {
            prev();
            startAutoPlay();
        });

        carousel.addEventListener('mouseenter', stopAutoPlay);
        carousel.addEventListener('mouseleave', startAutoPlay);

        activate(0);
        startAutoPlay();
    });
}

function initFaqAccordion() {
    document.querySelectorAll('[data-faq-trigger]').forEach((trigger) => {
        trigger.addEventListener('click', () => {
            const card = trigger.closest('[data-faq-card]');
            const body = card?.querySelector('[data-faq-body]');

            if (!card || !body) {
                return;
            }

            const willOpen = !card.classList.contains('is-open');
            document.querySelectorAll('[data-faq-card]').forEach((item) => item.classList.remove('is-open'));

            if (willOpen) {
                card.classList.add('is-open');
                body.style.maxHeight = `${body.scrollHeight}px`;
            } else {
                card.classList.remove('is-open');
                body.style.maxHeight = '0px';
            }
        });
    });
}

function initChatbot() {
    const toggleButtons = document.querySelectorAll('[data-chatbot-toggle]');
    const panel = document.querySelector('[data-chatbot-panel]');
    const form = document.querySelector('[data-chatbot-form]');
    const input = document.querySelector('[data-chatbot-input]');
    const messagesContainer = document.querySelector('[data-chatbot-messages]');

    if (!toggleButtons.length || !panel || !form || !input || !messagesContainer) {
        return;
    }

    const quickReplies = document.querySelectorAll('[data-chatbot-quick]');

    const knowledgeBase = {
        layanan: 'Untuk layanan pengajuan dana, monitoring SPJ, dan konsultasi pajak, silakan akses menu Program & Layanan atau hubungi Helpdesk melalui halaman Kontak.',
        dokumen: 'Repositori dokumen tersedia di menu Dokumen. Anda dapat memfilter berdasarkan kategori seperti RBA, laporan audit, maupun formulir layanan.',
        kontak: 'Kunjungi halaman Kontak untuk mendapatkan informasi hotline, email layanan dana, serta lokasi kantor Direktorat Keuangan.',
        faq: 'Pertanyaan yang sering diajukan dapat ditemukan pada bagian FAQ di halaman utama. Setiap jawaban tersedia dalam Bahasa Indonesia dan Inggris.',
    };

    const normalise = (value) => value.toLowerCase().normalize('NFKD').replace(/[^a-z0-9\s]/g, '');

    const appendMessage = (content, type = 'bot') => {
        const wrapper = document.createElement('div');
        wrapper.className = `chatbot-message ${type}`;

        const bubble = document.createElement('div');
        bubble.className = 'bubble';
        bubble.textContent = content;

        wrapper.appendChild(bubble);
        messagesContainer.appendChild(wrapper);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    };

    const respond = (text) => {
        appendMessage(text, 'user');

        window.setTimeout(() => {
            const normalised = normalise(text);
            const matched = Object.keys(knowledgeBase).find((key) => normalised.includes(key));

            if (matched) {
                appendMessage(knowledgeBase[matched]);
                return;
            }

            appendMessage('Terima kasih. Tim kami akan menghubungi Anda kembali. Sementara itu silakan jelajahi menu utama untuk informasi lebih rinci.');
        }, 600);
    };

    toggleButtons.forEach((button) => {
        button.addEventListener('click', () => {
            panel.classList.toggle('hidden');
        });
    });

    quickReplies.forEach((reply) => {
        reply.addEventListener('click', () => {
            const text = reply.getAttribute('data-chatbot-quick');
            if (!text) {
                return;
            }
            respond(text);
        });
    });

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        const value = input.value.trim();
        if (!value) {
            return;
        }
        respond(value);
        input.value = '';
    });

    appendMessage('Halo! Saya Asisten Keuangan Tel-U. Pilih menu di atas atau ajukan pertanyaan Anda.');
}

function initCampusMap() {
    const wrappers = document.querySelectorAll('.map-shell');

    if (!wrappers.length) {
        return;
    }

    const attemptInitialise = () => {
        if (typeof window.L === 'undefined') {
            window.setTimeout(attemptInitialise, 200);
            return;
        }

        wrappers.forEach((wrapper) => {
            if (wrapper.dataset.mapReady === 'true') {
                return;
            }

            const canvas = wrapper.querySelector('[data-map-canvas]');
            if (!canvas) {
                return;
            }

            const lat = parseFloat(wrapper.dataset.mapLat ?? '0');
            const lng = parseFloat(wrapper.dataset.mapLng ?? '0');

            if (Number.isNaN(lat) || Number.isNaN(lng)) {
                return;
            }

            const zoom = parseInt(wrapper.dataset.mapZoom ?? '17', 10) || 17;
            const map = L.map(canvas, {
                scrollWheelZoom: false,
                dragging: true,
            }).setView([lat, lng], zoom);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors',
                maxZoom: 20,
            }).addTo(map);

            const iconUrl = wrapper.dataset.mapMarker;
            const markerOptions = iconUrl
                ? {
                    icon: L.icon({
                        iconUrl,
                        iconSize: [44, 44],
                        iconAnchor: [22, 42],
                        popupAnchor: [0, -38],
                    }),
                }
                : undefined;

            const marker = L.marker([lat, lng], markerOptions).addTo(map);
            const popupTemplate = wrapper.querySelector('[data-map-popup]');

            if (popupTemplate) {
                marker.bindPopup(popupTemplate.innerHTML, {
                    autoPanPadding: [24, 24],
                }).openPopup();
            }

            wrapper.dataset.mapReady = 'true';

            if (typeof ResizeObserver !== 'undefined') {
                const resizeObserver = new ResizeObserver(() => map.invalidateSize());
                resizeObserver.observe(wrapper);
            } else {
                window.addEventListener('resize', () => map.invalidateSize(), { passive: true });
            }

            wrapper.addEventListener('mouseenter', () => map.scrollWheelZoom.enable());
            wrapper.addEventListener('mouseleave', () => map.scrollWheelZoom.disable());
        });
    };

    attemptInitialise();
}
