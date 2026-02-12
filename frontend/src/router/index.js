import { createRouter, createWebHistory } from "vue-router";

import Home from "@/views/Home.vue";
import Affichage from "@/views/Affichage.vue";
import Admin from "@/views/Admin.vue";

const routes = [
    {
        path : '/',
        name : 'Home',
        component : Home
    },
    {
        path : '/Affichage',
        name : 'Affichage',
        component : Affichage
    },
    {
        path : '/Admin',
        name : 'Admin',
        component : Admin
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router