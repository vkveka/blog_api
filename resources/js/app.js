import './bootstrap'
import "bootstrap/dist/css/bootstrap.min.css";
import 'bootstrap';
import { createApp } from 'vue'
import App from './App.vue'
import router from './router/router'
import { createPinia } from 'pinia'
import piniaPluginPersistedState from 'pinia-plugin-persistedstate'
import { VueMasonryPlugin } from 'vue-masonry';
import axios from 'axios';

const pinia = createPinia()
pinia.use(piniaPluginPersistedState)

createApp(App)
    .use(router)
    .use(pinia)
    .use(VueMasonryPlugin)
    .mount('#app')  