<template>
    <div class="overlay-loader d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary"></div>
    </div>
</template>
<script>
import { onMounted } from "vue";
import { useAuthUserStore } from "@store/user";
import { useRouter } from "vue-router";

export default {
    setup() {
        const router = useRouter();//for router

        onMounted(() => {
            handleLogin()
        })

        const handleLogin = async () => {
            useAuthUserStore().checkSocialLogin()
                .then((response) => {
                    console.log(response)
                    router.push('/dashboard');
                })
                .catch((error) => {
                    console.log(error)
                    router.push('/employee-login');
                });
        }

        return {
            handleLogin,
        }
    }
}
</script>
