import i18n from "../../lang";

const t = () => i18n;

export default [
    {
        path: "/dashboard",
        name: "dashboard",
        component: () => import("@views/Dashboard.vue"),
        meta: {
            requiresAuth: true,
            title: t("sidebar.dashboard"),
        },
    },
    // {
    //     path: "/edit-profile",
    //     name: "edit-profile",
    //     component: () => import("@views/user/EditProfile.vue"),
    //     meta: {
    //         requiresAuth: true,
    //         title: "Edit Profile"
    //     },
    // },
    // {
    //     path: "/change-password",
    //     name: "change-password",
    //     component: () => import("@views/user/ChangePassword.vue"),
    //     meta: {
    //         requiresAuth: true,
    //         title: "Change Password",
    //     },
    // },
    // {
    //     path: "/notifications",
    //     name: "notifications",
    //     component: () => import("@views/notifications/NotificationIndex.vue"),
    //     meta: {
    //         title: t("sidebar.notifications"),
    //         action: "read",
    //         module: "Notification",
    //     },
    // },
    // {
    //     path: "/roles",
    //     name: "roles",
    //     component: () => import("@views/roles/RoleIndex.vue"),
    //     meta: {
    //         requiresAuth: true,
    //         title: t("sidebar.roles"),
    //         action: "read",
    //         module: "Role",
    //     },
    // },
    // {
    //     path: "/roles/create",
    //     name: "role-create",
    //     component: () => import("@views/roles/RoleForm.vue"),
    //     meta: {
    //         requiresAuth: true,
    //         title: t("sidebar.roles"),
    //         action: "create",
    //         module: "Role",
    //     },
    // },
    // {
    //     path: "/roles/edit/:id?",
    //     name: "role-edit",
    //     component: () => import("@views/roles/RoleForm.vue"),
    //     meta: {
    //         requiresAuth: true,
    //         title: t("sidebar.roles"),
    //         action: "update",
    //         module: "Role",
    //     },
    // },
    // {
    //     path: "/roles/show/:id?",
    //     name: "role-show",
    //     component: () => import("@views/roles/RoleForm.vue"),
    //     meta: {
    //         requiresAuth: true,
    //         title: t("sidebar.roles"),
    //         action: "read",
    //         module: "Role",
    //     },
    // },

];
