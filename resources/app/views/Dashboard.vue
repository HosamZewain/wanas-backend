<script>
    import AdminHome from '@views/AdminHome.vue'

    export default {
        name: 'dashboard',

        components: {
            AdminHome,
        },

        computed: {
            currentHome() {
                return 'AdminHome';
            },
        },
    }

</script>

<template>
    <component :is="currentHome"></component>
</template>
