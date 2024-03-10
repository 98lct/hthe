/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import './bootstrap';
import { createApp } from 'vue';
import store from './store/index';
import http from './http';
import router from './router';
import ToastPlugin from 'vue-toast-notification';
import Vue3ConfirmDialog from 'vue3-confirm-dialog';
import 'vue-toast-notification/dist/theme-sugar.css';
import 'vue3-confirm-dialog/style';
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'
/* import the fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core'

/* import font awesome icon component */
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

/* import specific icons */

import { fas } from '@fortawesome/free-solid-svg-icons'

/* add icons to the library */
library.add(fas)

// Import components
import App from './App.vue';

const app = createApp(App);
app.use(store);
app.use(http);
app.use(router);
app.use(ToastPlugin);
app.use(ElementPlus);
app.component('font-awesome-icon', FontAwesomeIcon)
app.use(Vue3ConfirmDialog);
app.component('vue3-confirm-dialog', Vue3ConfirmDialog.default);
app.mount('#app');