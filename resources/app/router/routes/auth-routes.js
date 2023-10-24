import i18n from "../../lang";
import Login from "@views/Auth/Login.vue";

const t = () => i18n;

export default [
    {
        path: "/login",
        name: "login",
        component: Login,
        meta: {
            requiresAuth: true,
            title: t("messages.login"),
        },
    },
];
