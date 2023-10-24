<script setup>

import {useAuthUserStore} from "@store/user";

const userStore = useAuthUserStore();
const isAuth = userStore.user?.id;

</script>

<template>
    <div class="auth-content min-vh-100">
        <div class="container-fluid">
            <div class="row no-gutters">
                home
            </div>
        </div>
    </div>
</template>
