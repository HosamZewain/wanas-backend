<script setup>
import {reactive, shallowRef} from "vue";
import FormHelper from "@mixins/form";
import { useAuthUserStore } from "@store/user";
import { useRouter } from "vue-router";

const router = useRouter();
const loginForm = reactive({
    email: "",
    password: "",
    remember_me: false,
});
let errors = reactive([]);
const store = useAuthUserStore();
let isSubmitted = shallowRef(false);


async function handleLogin() {
    isSubmitted.value = true;
    useAuthUserStore()
        .login(loginForm)
        .then(() => {
            router.push({
                path: "/dashboard",
            });
        })
        .catch((error) => {
            console.log(error);
            FormHelper.prepareValidations(error.response.data.errors);
            errors.value = FormHelper.formErrors;
        })
        .finally(()=>{
            isSubmitted.value = false;
        });
}
</script>

<template>
    <div class="auth-content min-vh-100"  :style="{background:`url(${publicPath}/assets/images/bg.png) no-repeat center left/100% 100%`}">
        <div class="container-fluid">
            <div class="row no-gutters">
                <!-- discription -->
                <div class="col-md-7 col-sm-12">
                    <div class="auth-logo text-center my-5">
                        <img
                            :src="`${publicPath}/assets/images/login-logo.png`"
                            class="logo-img"
                            alt="logo"
                        />
                    </div>
                    <h1 class="main-heder text-center mb-5">Login</h1>
                    <p class="text-center main-p text-capitalize mb-5">
                        Wanas
                    </p>

                    <div class="authForm mb-3">
                        <form>
                            <form-input
                                class="mb-3"
                                label="pages.email"
                                type="email"
                                :model="loginForm"
                                name="email"
                                :errors="errors.value"
                            />
                            <form-input
                                class="mb-3"
                                label="pages.password"
                                type="password"
                                :model="loginForm"
                                name="password"
                                :errors="errors.value"
                            />

                            <div class="d-flex align-items-center justify-content-between flex-wrap mt-4">
                                <div class="mb-4">
                                    <el-checkbox
                                        v-model="loginForm.remember_me"
                                        :label="$t('pages.remember_me')"
                                    />
                                </div>

                                <div class="mb-4">
                                    <!-- <router-link :to="{name:'customer_forgot_password'}" class="forgotPass text-white">
                                        {{ $t("pages.forgot_password") }}
                                    </router-link> -->
                                </div>
                            </div>


                            <button
                                type="submit"
                                @click.prevent="handleLogin"
                                :disabled="isSubmitted"
                                class="btn ripple btn-primary w-100 fw-bold fs-15 authBtn"
                            >
                                {{ $t("global.sign_in") }}
                            </button>

                            <div
                                class="ormain position-relative text-center mt-4"
                            >
                                <span class="or">OR</span>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- image -->
                <div class="col-md-5 d-none d-sm-none d-md-block">
                    <img
                        :src="`${publicPath}/assets/images/img.png`"
                        alt="img"
                        class="side-img w-100 h-100"
                    />
                </div>
            </div>
        </div>
    </div>

</template>
