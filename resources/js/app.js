import './bootstrap';
import '../css/app.css';
import { createApp } from 'vue';
import ConceptMap from './components/ConceptMap.vue';
import "flatpickr/dist/flatpickr.min.css";
import flatpickr from 'flatpickr';
import Alpine from 'alpinejs';
import sq3rQuestions from './alpine-components/sq3r-questions';

window.flatpickr = flatpickr;
window.Alpine = Alpine;

Alpine.data('questionManager', sq3rQuestions);

// Initialize Alpine dengan animasi
try {
    Alpine.start();
    console.log("✅ Alpine berhasil diinisialisasi");
} catch (e) {
    console.warn('Peringatan inisialisasi Alpine:', e.message);
}

// Vue.js initialization dengan animasi
const vueApp = createApp({
    components: {
        ConceptMap
    }
});

// Mount Vue app dengan animasi
document.addEventListener('DOMContentLoaded', function () {
    const vueContainer = document.getElementById('vue-app');
    if (vueContainer) {
        try {
            vueApp.mount('#vue-app');
            console.log("✅ Aplikasi Vue berhasil dimuat");

            // Tambahkan animasi pada container
            vueContainer.style.animation = 'fadeInUp 0.8s ease-out';
        } catch (e) {
            console.error('❌ Kesalahan pemasangan Vue:', e);
        }
    }
});

// Error handling yang lebih baik
window.addEventListener('error', (e) => {
    if (e.message && (
        e.message.includes('Alpine Expression Error') ||
        e.message.includes('tidak didefinisikan') ||
        e.message.includes('Cannot read properties of null')
    )) {
        console.warn('Kesalahan Alpine yang ditekan:', e.message);
        e.preventDefault();
        e.stopPropagation();
        return false;
    }
});

// Safe selectors dengan animasi
window.safeQuerySelector = function(selector, callback) {
    const element = document.querySelector(selector);
    if (element) {
        callback(element);
        // Tambahkan animasi pada elemen
        element.style.animation = 'fadeInUp 0.4s ease-out';
    } else {
        console.warn(`Elemen tidak ditemukan: ${selector}`);
    }
    return element;
};

// Safe event listeners dengan delegasi
window.safeEventListener = function(selector, event, handler, parent = document) {
    const elements = parent.querySelectorAll(selector);
    elements.forEach(element => {
        if (element && element.addEventListener) {
            element.addEventListener(event, handler);
            // Tambahkan animasi hover
            element.classList.add('hover-lift');
        }
    });

    if (parent && parent.addEventListener) {
        parent.addEventListener(event, (e) => {
            if (e.target.matches(selector)) {
                handler(e);
                // Animasi klik
                e.target.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    e.target.style.transform = '';
                }, 150);
            }
        });
    }
};

// Fungsi filter modern dengan animasi
document.addEventListener('DOMContentLoaded', function () {
    function setupFilters(formSelector, itemsSelector) {
        const form = document.querySelector(formSelector);
        const items = document.querySelectorAll(itemsSelector);

        if (!form || items.length === 0) return;

        const inputs = form.querySelectorAll('select, input[type="text"], input[type="number"]');

        inputs.forEach(input => {
            // Tambahkan animasi pada input
            input.addEventListener('focus', function() {
                this.style.transform = 'scale(1.02)';
            });

            input.addEventListener('blur', function() {
                this.style.transform = '';
            });

            input.addEventListener('change', filterItems);
            input.addEventListener('keyup', debounce(filterItems, 300));
        });

        function filterItems() {
            const formData = new FormData(form);
            const filters = {};

            for (let [key, value] of formData.entries()) {
                filters[key] = value.toLowerCase();
            }

            items.forEach((item, index) => {
                let show = true;

                for (let [key, value] of Object.entries(filters)) {
                    if (value && !item.matches(`[data-${key}*="${value}"], [data-${key}="${value}"]`)) {
                        show = false;
                        break;
                    }
                }

                // Animasi muncul/hilang
                if (show) {
                    item.style.display = '';
                    item.style.animation = `fadeInUp 0.4s ease-out ${index * 0.05}s both`;
                } else {
                    item.style.animation = 'fadeOut 0.3s ease-out';
                    setTimeout(() => {
                        item.style.display = 'none';
                    }, 300);
                }
            });
        }
    }

    setupFilters('#weekly-plans-filter', '.weekly-plan-item');
    setupFilters('#monitorings-filter', '.monitoring-item');
    setupFilters('#concept-maps-filter', '.concept-map-item');
    setupFilters('#sq3r-filter', '.sq3r-item');

    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
});

// Animasi validasi tanggal modern
document.addEventListener('DOMContentLoaded', function () {
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');

    if (!startDateInput || !endDateInput) return;

    function validateDates() {
        if (startDateInput.value && endDateInput.value) {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);

            if (endDate <= startDate) {
                endDateInput.setCustomValidity('Tanggal akhir harus setelah tanggal mulai');
                endDateInput.style.borderColor = '#ef4444';
                endDateInput.style.animation = 'shake 0.5s ease-in-out';
            } else {
                endDateInput.setCustomValidity('');
                endDateInput.style.borderColor = '';
            }
        }
    }

    startDateInput.addEventListener('change', validateDates);
    endDateInput.addEventListener('change', validateDates);

    validateDates();
});

// Animasi shake untuk error
const style = document.createElement('style');
style.textContent = `
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }

    @keyframes fadeOut {
        from { opacity: 1; transform: translateY(0); }
        to { opacity: 0; transform: translateY(-10px); }
    }
`;
document.head.appendChild(style);

// Inisialisasi aplikasi dengan animasi
function initializeApp() {
    // Tambahkan animasi pada semua elemen interaktif
    document.querySelectorAll('button, a, .card, .nav-link').forEach(element => {
        element.classList.add('hover-lift');
    });

    window.addEventListener('error', (e) => {
        if (e.message && (
            e.message.includes('Alpine Expression Error') ||
            e.message.includes('tidak didefinisikan') ||
            e.message.includes('Cannot read properties of null') ||
            e.message.includes('addEventListener')
        )) {
            console.warn('Kesalahan Alpine yang ditekan:', e.message);
            e.preventDefault();
            e.stopPropagation();
            return false;
        }
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeApp);
} else {
    initializeApp();
}

// Loading animation
window.addEventListener('load', function() {
    document.body.style.opacity = '0';
    document.body.style.transition = 'opacity 0.5s ease-in-out';
    setTimeout(() => {
        document.body.style.opacity = '1';
    }, 100);
});
