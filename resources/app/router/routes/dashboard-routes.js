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
    {
        path: "/roles",
        name: "roles",
        component: () => import("@views/roles/RoleIndex.vue"),
        meta: {
            requiresAuth: true,
            title: t("sidebar.roles"),
            action: "read",
            module: "Role",
        },
    },
    {
        path: "/roles/create",
        name: "role-create",
        component: () => import("@views/roles/RoleForm.vue"),
        meta: {
            requiresAuth: true,
            title: t("sidebar.roles"),
            action: "create",
            module: "Role",
        },
    },
    {
        path: "/roles/edit/:id?",
        name: "role-edit",
        component: () => import("@views/roles/RoleForm.vue"),
        meta: {
            requiresAuth: true,
            title: t("sidebar.roles"),
            action: "update",
            module: "Role",
        },
    },
    {
        path: "/roles/show/:id?",
        name: "role-show",
        component: () => import("@views/roles/RoleForm.vue"),
        meta: {
            requiresAuth: true,
            title: t("sidebar.roles"),
            action: "read",
            module: "Role",
        },
    },
    {
        path: "/vehicles-types",
        name: "vehicles-types",
        component: () => import("@views/vehiclesTypes/VehiclesTypesIndex.vue"),
        meta: {
            requiresAuth: true,
            title: t("sidebar.vehicles_types"),
            action: "read",
            module: "VehiclesType",
        },
    },
    {
        path: "/vehicles-types/create",
        name: "vehicles-types-create",
        component: () => import("@views/vehiclesTypes/VehiclesTypesForm.vue"),
        meta: {
            requiresAuth: true,
            title: t("sidebar.vehicles_types"),
            action: "create",
            module: "VehiclesType",
        },
    },
    {
        path: "/vehicles-types/edit/:id?",
        name: "vehicles-types-edit",
        component: () => import("@views/vehiclesTypes/VehiclesTypesForm.vue"),
        meta: {
            requiresAuth: true,
            title: t("sidebar.vehicles_types"),
            action: "update",
            module: "VehiclesType",
        },
    },
    {
        path: "/pages",
        name: "pages",
        component: () => import("@views/pages/PagesIndex.vue"),
        meta: {
            requiresAuth: true,
            title: t("sidebar.pages"),
            action: "read",
            module: "Page",
        },
    },
    {
        path: "/pages/create",
        name: "pages-create",
        component: () => import("@views/pages/PageForm.vue"),
        meta: {
            requiresAuth: true,
            title: t("sidebar.pages"),
            action: "create",
            module: "Page",
        },
    },
    {
        path: "/pages/edit/:id?",
        name: "pages-edit",
        component: () => import("@views/pages/PageForm.vue"),
        meta: {
            requiresAuth: true,
            title: t("sidebar.pages"),
            action: "update",
            module: "Page",
        },
    },
    {
        path: "/governorates",
        name: "governorates",
        component: () => import("@views/governorates/GovernoratesIndex.vue"),
        meta: {
            requiresAuth: true,
            title: t("sidebar.governorates"),
            action: "read",
            module: "Governorate",
        },
    },
    {
        path: "/governorates/create",
        name: "governorates-create",
        component: () => import("@views/governorates/GovernorateForm.vue"),
        meta: {
            requiresAuth: true,
            title: t("sidebar.governorates"),
            action: "create",
            module: "Governorate",
        },
    },
    {
        path: "/governorates/edit/:id?",
        name: "governorates-edit",
        component: () => import("@views/governorates/GovernorateForm.vue"),
        meta: {
            requiresAuth: true,
            title: t("sidebar.governorates"),
            action: "update",
            module: "Governorate",
        },
    },
    {
        path: "/countries",
        name: "countries",
        component: () => import("@views/countries/CountriesIndex.vue"),
        meta: {
            requiresAuth: true,
            title: t("sidebar.countries"),
            action: "read",
            module: "Country",
        },
    },
    {
        path: "/countries/create",
        name: "countries-create",
        component: () => import("@views/countries/CountryForm.vue"),
        meta: {
            requiresAuth: true,
            title: t("sidebar.countries"),
            action: "create",
            module: "Country",
        },
    },
    {
        path: "/countries/edit/:id?",
        name: "countries-edit",
        component: () => import("@views/countries/CountryForm.vue"),
        meta: {
            requiresAuth: true,
            title: t("sidebar.countries"),
            action: "update",
            module: "Country",
        },
    }

];
