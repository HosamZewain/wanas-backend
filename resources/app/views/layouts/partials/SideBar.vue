<template>
    <div class="main-navbar side-menu main-sidebar-sticky">
        <div class="sidemenu-logo">
            <a class="main-logo" href="/dashboard">
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
                    <li
                        :class="`nav-item ${
                            this.$route.name === 'dashboard' ? 'active' : ''
                        }`"
                    >
                        <router-link to="/dashboard" class="nav-link">
                            <i class="las la-tv me-2"></i>
                            <span class="sidemenu-label">{{
                                $t("sidebar.dashboard")
                            }}</span>
                        </router-link>
                    </li>

                    <li class="nav-item"
                        v-if="
                            hasAnyPermission('read', [
                                'Role', 'VehiclesType'
                            ])
                        ">
                        <a class="nav-link subMenu with-sub">
                            <i class="fas fa-sliders me-2"></i>
                            <span class="sidemenu-label">{{
                                $t("pages.setups")
                            }}</span>
                        </a>
                        <ul class="nav-sub">
                            <li :class="`nav-sub-item${this.$route.name === 'roles'? 'active': ''}`"
                                v-if="hasPermission('read', 'Role')">
                                <router-link :to="{name: 'roles'}" class="nav-sub-link">
                                    <span class="sidemenu-label">{{ $t("sidebar.roles") }}</span>
                                </router-link>
                            </li>
                        </ul>
                        <ul class="nav-sub">
                            <li :class="`nav-sub-item${this.$route.name === 'vehicles-types'? 'active': ''}`"
                                v-if="hasPermission('read', 'VehiclesType')">
                                <router-link :to="{name: 'vehicles-types'}" class="nav-sub-link">
                                    <span class="sidemenu-label">{{ $t("sidebar.vehicles_types") }}</span>
                                </router-link>
                            </li>
                        </ul>
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

        $("body").append('<div class="main-navbar-backdrop"></div>');

        $(".main-navbar-backdrop").on("click touchstart", function () {
            $("body").removeClass("main-navbar-show");
        });
    },
};
</script>
