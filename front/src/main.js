import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faAngleLeft,faCirclePlus,faCircleMinus, faCircleXmark, faPenToSquare, faFileExport, faXmark } from '@fortawesome/free-solid-svg-icons';

library.add(faAngleLeft,faCirclePlus,faCircleMinus, faCircleXmark, faPenToSquare, faFileExport, faXmark);
const app = createApp(App);
app.component('font-awesome-icon', FontAwesomeIcon);
app.use(router);
app.mount('#app');
