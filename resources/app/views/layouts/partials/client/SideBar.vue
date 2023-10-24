<template>
    <div class="main-navbar side-menu main-sidebar-sticky">
        <div class="sidemenu-logo">
            <a class="main-logo" href="/customer/dashboard">
                <img
                    :src="`${publicPath}/assets/images/logo.png`"
                    class="header-brand-img desktop-logo"
                    alt="logo"
                />
                <img
                    :src="`${publicPath}/assets/images/roqay-logo.png`"
                    class="header-brand-img icon-logo"
                    alt="logo"
                />
                <img
                    :src="`${publicPath}/assets/images/logo-light.png`"
                    class="header-brand-img desktop-logo theme-logo"
                    alt="logo"
                />
                <img
                    :src="`${publicPath}/assets/images/icon-light.png`"
                    class="header-brand-img icon-logo theme-logo"
                    alt="logo"
                />
            </a>
        </div>
        <div class="container main-sidemenu">
            <div class="main-sidebar-body">
                <ul class="nav">
                    <li :class="`nav-item ${this.$route.name === 'customer/dashboard' ? 'active' : ''}`">
                        <router-link to="/customer/dashboard" class="nav-link">
                            <i class="las la-tv me-2"></i>
                            <span class="sidemenu-label">{{
                                $t("sidebar.dashboard")
                            }}</span>
                        </router-link>
                    </li>

                    <li
                        :class="`nav-item ${
                            this.$route.name === 'customer-projects' ? 'active' : ''
                        }`"
                        v-if="hasPermission('read', 'Project')"
                    >
                        <router-link :to="{name: 'customer-projects'}" class="nav-link">
                            <i class="fas fa-users-class me-2"></i>
                            <span class="sidemenu-label">{{
                                $t("sidebar.projects")
                            }}</span>
                        </router-link>
                    </li>

                    <li
                        :class="`nav-item ${
                            this.$route.name === 'customer-tickets' ? 'active' : ''
                        }`"
                        v-if="hasPermission('read', 'Ticket')"
                    >
                        <router-link :to="{name: 'customer-tickets'}" class="nav-link">
                            <i class="las la-users me-2"></i>
                            <span class="sidemenu-label">{{
                                $t("sidebar.support_tickets")
                            }}</span>
                        </router-link>
                    </li>

                    <li
                        :class="`nav-item ${
                            this.$route.name === 'customer-slas' || this.$route.name === 'slas.create'? 'active' : ''
                        }`"
                        v-if="hasPermission('read', 'Sla')"
                    >
                        <router-link :to="{name: 'customer-slas'}" class="nav-link">
                            <i class="las la-users me-2"></i>
                            <span class="sidemenu-label">{{
                                $t("sidebar.slas")
                            }}</span>
                        </router-link>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "side-bar",
    mounted: function () {
        $(".main-navbar .subMenu").on("click", function (e) {
            e.preventDefault();
            $(this).parent().toggleClass("show");
            $(this).parent().siblings().removeClass("show");
        });
    },
};
</script>
