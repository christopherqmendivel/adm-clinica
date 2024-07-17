import { createApp } from 'vue';
import App from './App.vue';
import router from './router';

// Variables CSS
import './assets/variables/variables.css'; 
import './assets/fonts/fonts.css'; 


import Toast, { POSITION } from 'vue-toastification';
import 'vue-toastification/dist/index.css';

// Importar BootstrapVue
import { BootstrapVueNext } from 'bootstrap-vue-next';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue-next/dist/bootstrap-vue-next.css';


const app = createApp(App);

app.use(router);
app.use(Toast, {
  position: POSITION.TOP_RIGHT
});

// Usar BootstrapVue
app.use(BootstrapVueNext);


app.mount('#app');
