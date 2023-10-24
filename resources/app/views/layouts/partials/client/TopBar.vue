<script setup>

import {onMounted, ref} from "vue";
import {useAuthUserStore} from "@store/user";
import {useRouter} from "vue-router";
import CustomerApi from "@api/customer.api";
import {getToken, onMessage} from "firebase/messaging";
import {ElNotification} from "element-plus";

const store = useAuthUserStore();
const username = store.user.name;
const roles = store.user.roles;
const router = useRouter();
const embed = ref("projects,user.notifications,avatar");
const customer = ref({});
const hasUnReadNotifications = ref(true);

async function toggleSideBar() {
    if ($('#mainNavShow').closest('.with-side-menu').length === 1) {
        if ($(window).innerWidth() <= '991.98') {
            $('body').addClass('main-navbar-show');
        } else {
            $('body').toggleClass('main-sidebar-hide');
        }
    } else {
        $('body').addClass('main-navbar-show');
    }
}

async function fullScreenMode() {
    $('html').addClass('fullscreenie');
    if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document.mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {
        if (document.documentElement.requestFullScreen) {
            document.documentElement.requestFullScreen();
        } else if (document.documentElement.mozRequestFullScreen) {
            document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullScreen) {
            document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
        } else if (document.documentElement.msRequestFullscreen) {
            document.documentElement.msRequestFullscreen();
        }
    } else {
        $('html').removeClass('fullscreenie');
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
    }
}

// slide up any dropdown on document click
$(document).on("click touchstart", function (e) {
    e.stopPropagation();
    var dropTarg = $(e.target).closest(".main-header .dropdown").length;
    if (!dropTarg) {
        $(".main-header .dropdown").removeClass("show");
    }
    if (window.matchMedia("(min-width: 992px)").matches) {
        var navTarg = $(e.target).closest(".main-navbar .nav-item").length;
        if (!navTarg) {
            $(".main-navbar .show").removeClass("show");
        }
        var menuTarg = $(e.target).closest(
            ".main-header-menu .nav-item"
        ).length;
        if (!menuTarg) {
            $(".main-header-menu .show").removeClass("show");
        }
        if ($(e.target).hasClass("main-menu-sub-mega")) {
            $(".main-header-menu .show").removeClass("show");
        }
    }
    var sidebarTarg = $(e.target).closest(".sidebar").length;
    if (
        $(e.target).is(
            ".main-header .header-settings a , .main-header .header-settings i, .sidebar"
        ) === false &&
        !sidebarTarg
    ) {
        if ($(".sidebar").hasClass("sidebar-open")) {
            console.log(e.target);
            $(".sidebar.sidebar-open").removeClass("sidebar-open");
        }
    }
    let sideSetting = $(".sideSetting");
    if (!sideSetting.is(e.target) && sideSetting.has(e.target).length === 0) {
        sideSetting.removeClass("sidebar-open");
    }
});

async function logout() {
    store.logout()
        .then((response) => {
            router.push({
                path: '/login'
            });
        })
        .catch((error) => {
            console.log(error);
        });
}


async function getAuthCustomer() {
    CustomerApi.get(store.user.customer, {embed: embed.value})
        .then((response) => {
            customer.value = response.data.data;
        })
        .catch((error) => {
            console.log(error);
        });
}

onMounted(async () => {
    $('.main-header .dropdown > a').on('click', function (e) {
        e.preventDefault();
        $(this).parent().toggleClass('show');
        $(this).parent().siblings().removeClass('show');
    });
    await getAuthCustomer();
});

// notification
onMessage(window.fcmMessaging, (payload) => {
    customer.value.user?.notifications?.unshift(payload.notification);
    ElNotification({
        title: payload.notification.title,
        message: payload.notification.body,
        type: payload.data?.type ?? "info",
        position: "bottom-right",
        duration: 5000,
        offset: 50,
        onClick: function () {
            const route = payload?.data?.route;
            if (route) {
                router.push(route);
            } else {
                router.push({
                    path: "/customer/notifications",
                });
            }
        },
    });
});

getToken(window.fcmMessaging, {
    vapidKey: import.meta.env.VITE_FIREBASE_VAPID_PUBLIC_KEY,
})
    .then(async (currentToken) => {
        if (!store.fcm_tokens.includes(currentToken)) {
            store.updateToken(currentToken);
        }
    })
    .catch((err) => {
        console.log("An error occurred while retrieving token. ", err);
    });

</script>

<template>
    <div class="main-header with-side-menu">
        <div class="container">
            <div class="main-header-left">
                <a id="mainNavShow" class="main-header-menu-icon d-lg-none" href="javascript:void(0)"
                   @click="toggleSideBar()"><span></span></a>
                <router-link :to="{name: 'customer-dashboard'}" class="main-logo">
                    <img :src="`${publicPath}/assets/images/logo.png`" alt="logo" class="header-brand-img desktop-logo">
                    <img :src="`${publicPath}/assets/images/roqay-logo.png`" alt="logo"
                         class="header-brand-img icon-logo">
                    <img :src="`${publicPath}/assets/images/logo-light.png`"
                         alt="logo" class="header-brand-img desktop-logo theme-logo">
                    <img :src="`${publicPath}/assets/images/icon-light.png`"
                         alt="logo" class="header-brand-img icon-logo theme-logo">
                </router-link>
            </div>

            <div class="main-header-right">
                <div class="dropdown d-md-flex">
                    <a class="nav-link icon full-screen-link" @click="fullScreenMode()">
                        <i class="las la-expand fullscreen-button"></i>
                    </a>
                </div>
                <div class="dropdown main-header-notification">
                    <a class="nav-link icon" href="">
                        <i class="fa-solid fa-bell"></i>
                    </a>
                    <div class="dropdown-menu">
                        <ul v-if="customer.user?.notifications?.length" class="main-notification-list">
                            <li
                                v-for="not in customer.user?.notifications"
                                class="media d-flex"
                            >
                                <router-link
                                    :to="not.data?.route ?? '/customer/notifications'"
                                    class="flex-grow-1 media-body"
                                >
                                    {{ not.body }}
                                    <span>{{ not.datetime }}</span>
                                </router-link>
                            </li>
                        </ul>
                        <ul v-if="!customer.user?.notifications?.length" class="main-notification-list">
                            <li class="media text-center">
                                {{ $t("pages.no_data") }}
                            </li>
                        </ul>
                        <div class="noti-footer text-center">
                            <router-link
                                class="text-primary"
                                to="/customer/notifications"
                            >
                                {{ $t("pages.view_all") }}
                            </router-link>
                        </div>
                    </div>
                </div>
                <div class="dropdown main-profile-menu">
                    <a class="main-img-user" href="">
                        <img :src="customer.avatar_view?.url" alt="avatar"/>
                    </a>
                    <div class="dropdown-menu">
                        <div class="header-navheading text-center">
                            <h6 class="main-headNav-title">{{ username }}</h6>
                            <p class="main-headNav-text">{{ roles }}</p>
                        </div>
                        <ul class="profileMenu">
                            <li class="dropdown-item">
                                <router-link :to="{name: 'customer-edit-profile'}">
                                    <i class="las la-user"></i> {{ $t('pages.profile') }}
                                </router-link>
                            </li>
                            <li class="dropdown-item">
                                <a href="#" @click.prevent="logout">
                                    <i class="las la-power-off"></i> {{ $t('pages.sign_out') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
