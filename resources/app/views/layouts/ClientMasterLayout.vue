<script>
    import TopBar from "@views/layouts/partials/client/TopBar.vue";
    import SideBar from "@views/layouts/partials/client/SideBar.vue";
    import FooterBar from "@views/layouts/partials/FooterBar.vue";

    export default {
        name: 'master-layout',
        components: {
            FooterBar,
            TopBar,
            SideBar
        },
        created() {
        }
    }

</script>

<template>
    <!-- start main header -->
    <top-bar/>
    <!-- end main header -->
    <!-- start horizontal menu -->
    <side-bar/>
    <!-- end horizontal menu -->
    <!-- start main content -->
    <router-view :key="$route.fullPath"></router-view>
    <!-- end main content -->
    <!-- start footer -->
    <footer-bar/>
    <!-- end footer -->
</template>
