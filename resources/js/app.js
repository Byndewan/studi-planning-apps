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

// Initialize Alpine
try {
    Alpine.start();
} catch (e) {
    console.warn('Alpine initialization warning:', e.message);
}

// Vue.js initialization
const vueApp = createApp({
    components: {
        ConceptMap
    }
});

// Mount Vue app ketika DOM ready
document.addEventListener('DOMContentLoaded', function () {
    const vueContainer = document.getElementById('vue-app');
    if (vueContainer) {
        try {
            vueApp.mount('#vue-app');
            console.log("✅ Vue app mounted successfully");
        } catch (e) {
            console.error('❌ Vue mounting error:', e);
        }
    }
});

// Error handling
window.addEventListener('error', (e) => {
    if (e.message && (
        e.message.includes('Alpine Expression Error') ||
        e.message.includes('is not defined') ||
        e.message.includes('Cannot read properties of null')
    )) {
        console.warn('Suppressed Alpine.js error:', e.message);
        e.preventDefault();
        e.stopPropagation();
        return false;
    }
});

// Safe selectors and event listeners
window.safeQuerySelector = function(selector, callback) {
    const element = document.querySelector(selector);
    if (element) {
        callback(element);
    } else {
        console.warn(`Element not found: ${selector}`);
    }
    return element;
};

window.safeEventListener = function(selector, event, handler, parent = document) {
    const elements = parent.querySelectorAll(selector);
    elements.forEach(element => {
        if (element && element.addEventListener) {
            element.addEventListener(event, handler);
        }
    });

    if (parent && parent.addEventListener) {
        parent.addEventListener(event, (e) => {
            if (e.target.matches(selector)) {
                handler(e);
            }
        });
    }
};

window.safeAddEventListener = function(element, event, handler) {
    if (element && element.addEventListener) {
        element.addEventListener(event, handler);
    }
};

// Filter functionality (existing)
document.addEventListener('DOMContentLoaded', function () {
    function setupFilters(formSelector, itemsSelector) {
        const form = document.querySelector(formSelector);
        const items = document.querySelectorAll(itemsSelector);

        if (!form || items.length === 0) return;

        const inputs = form.querySelectorAll('select, input[type="text"], input[type="number"]');

        inputs.forEach(input => {
            input.addEventListener('change', filterItems);
            input.addEventListener('keyup', debounce(filterItems, 300));
        });

        function filterItems() {
            const formData = new FormData(form);
            const filters = {};

            for (let [key, value] of formData.entries()) {
                filters[key] = value.toLowerCase();
            }

            items.forEach(item => {
                let show = true;

                for (let [key, value] of Object.entries(filters)) {
                    if (value && !item.matches(`[data-${key}*="${value}"], [data-${key}="${value}"]`)) {
                        show = false;
                        break;
                    }
                }

                item.style.display = show ? '' : 'none';
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

// Date validation (existing)
document.addEventListener('DOMContentLoaded', function () {
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');

    if (!startDateInput || !endDateInput) return;

    function validateDates() {
        if (startDateInput.value && endDateInput.value) {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);

            if (endDate <= startDate) {
                endDateInput.setCustomValidity('End date must be after start date');
            } else {
                endDateInput.setCustomValidity('');
            }
        }
    }

    startDateInput.addEventListener('change', validateDates);
    endDateInput.addEventListener('change', validateDates);

    validateDates();
});

// Initialize app
function initializeApp() {
    window.addEventListener('error', (e) => {
        if (e.message && (
            e.message.includes('Alpine Expression Error') ||
            e.message.includes('is not defined') ||
            e.message.includes('Cannot read properties of null') ||
            e.message.includes('addEventListener')
        )) {
            console.warn('Suppressed Alpine.js error:', e.message);
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
