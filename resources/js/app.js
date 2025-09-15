import './bootstrap';
import '../css/app.css';
import { createApp } from 'vue';
import ConceptMap from './components/ConceptMap.vue';
import Alpine from 'alpinejs';

import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";

window.Alpine = Alpine;
Alpine.start();

window.flatpickr = flatpickr;

const app = createApp({});
app.component('ConceptMap', ConceptMap);
app.mount('#app');
