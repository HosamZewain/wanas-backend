import NotFound from "@views/NotFound.vue";
import Forbidden from "@views/Forbidden.vue";
import AuthLayout from "@views/layouts/AuthLayout.vue";
import HomeLayout from "@views/layouts/HomeLayout.vue";
import MasterLayout from "@views/layouts/MasterLayout.vue";

import AuthRoutes from './routes/auth-routes'
import DashboardRoutes from './routes/dashboard-routes'

export default [
    {
        path: '/auth',
        redirect: '/login',
        component: AuthLayout,
        children: AuthRoutes,
    },
    {
        path: '/dashboard',
        redirect: '/dashboard',
        component: MasterLayout,
        meta: {
            requiresAuth: true
        },
        children: DashboardRoutes,
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'not-found',
        component: NotFound
    },
    {
        path: '/403',
        name: 'forbidden',
        component: Forbidden
    },

    {
        path: '/',
        name: 'home',
        component: HomeLayout,
    },
]
