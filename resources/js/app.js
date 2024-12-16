require('./bootstrap');
import { createApp } from 'vue';
import Notifications from './components/Notifications.vue';

const app = createApp({});
app.component('notifications', Notifications);
app.mount('#app');

