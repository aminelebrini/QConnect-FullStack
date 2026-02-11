import { createRouter, createWebHistory } from "vue-router";

import Home from "@/views/Home.vue";
import Affichage from "@/views/Affichage.vue";

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
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router