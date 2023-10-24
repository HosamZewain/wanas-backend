import {
    createRouter,
    createWebHistory
} from "vue-router";

import routes from "@/router/routes";

import {checkAccessMiddleware,dashboardRedirect} from './middlewares/checkAccessMiddleware';

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(dashboardRedirect);
router.beforeEach(checkAccessMiddleware);

export default router
