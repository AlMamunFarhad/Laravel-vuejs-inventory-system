import './bootstrap';
import 'noty/lib/noty.css';


import { createApp } from 'vue';
import App from './App.vue';
import router from './router.js'; 
// Import User class
import user from './Helpers/User';
window.user = user;

// // sweet alert
import Swal from 'sweetalert2';
window.Swal = Swal;

// noty alert
import notification from './Helpers/Notification';
window.notification = notification;


const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.onmouseenter = Swal.stopTimer;
      toast.onmouseleave = Swal.resumeTimer;
    }
  });

  window.Toast = Toast;
 
  
const app = createApp(App);
app.use(router);
app.mount('#app');


