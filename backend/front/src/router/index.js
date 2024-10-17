import { createRouter,createWebHistory } from 'vue-router'
import Client from '../views/Client.vue'
import Devis from '../views/Devis.vue'
import Voiture from '@/views/Voiture.vue';
const router =createRouter({
    history:createWebHistory(),
    routes:[
        {path:'/',component:Client},
        {path:'/devis',component:Devis},
        {path:'/voiture',component:Voiture},
   
    ]
})
export default router;