<script>
import {
    useToast
} from "vue-toastification";

export default {
    name: 'forget-password',
    data() {
        return {
            forgetForm: {
                email: '',
            },
            error: ''
        }
    },
    methods: {
        handleForget() {
            this.$store.dispatch('user/resetPassword', this.forgetForm)
                .then((response) => {
                    useToast().success(response.data.message);
                    this.$router.push({
                        path: '/login'
                    });
                })
                .catch((error) => {
                    // console.log(error);
                    this.error = error.response.data.errors;
                });
        }
    }
}

</script>

<template>
    <div class="col-md-7">
        <div class="auth-blk bg-white px-4 py-5">

            <h3 class="mb-4 font-weight-medium bordered-title text-center text-primary">
                <span>إعادة تعيين كلمة المرور</span>
            </h3>
            <p class="mb-4 font-weight-medium text-center text-primary mb-2 text-sm">
                من فضلك أدخل بريدك الإلكتروني للتمكن من الوصول حسابك
            </p>
            <div class="mt-5">
                <form method="POST" action="#">
                    <div class="form-group">
                        <label for="emailAddress">البريد الإلكتروني</label>
                        <input v-model="forgetForm.email" type="email" class="form-control" name="emailAddress"
                               id="emailAddress" placeholder=" البريد الإلكتروني ">
                        <small class="text-danger" v-if="error['email']">{{ error['email'][0] }}</small>
                    </div>
                    <div class="d-flex justify-content-between my-4 py-2">
                        <button type="submit" class="btn btn-secondary" @click.prevent="handleForget">
                            إعادة تعيين كلمة المرور
                        </button>
                    </div>
                    <div class="form-group d-flex justify-content-end my-4 ">
                        <div class="mt-5">
                            <router-link to="/login">العودة إلي تسجيل الدخول ؟</router-link>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
