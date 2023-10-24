<template>
    <div class="error-bg main-error-wrapper min-vh-100">
        <div class="row align-items-center d-flex flex-row">
            <div class="col-lg-6 text-end pe-lg-4">
                <h1 class="mb-0"><span class="fa fa-ban"></span>403</h1>
            </div>
            <div class="col-lg-6">
                <h2>Oops.The Page you are looking for you don't have permission to it..</h2>
                <h6>You may have mistyped the address or the page may have moved. Try searching below or contact system Adminstrator.</h6>

                <router-link
                    v-if="userRoles.includes('customer')"
                    class="btn ripple btn-primary text-center text-white w-fit-content"
                    to="/customer/dashboard">
                    Back to Home
                </router-link>

                <router-link v-else class="btn ripple btn-primary text-center text-white w-fit-content" to="/">Back to Home</router-link>
            </div>
        </div>
    </div>
</template>

<script>
import {useAuthUserStore} from "@store/user";

export default {
    name: "Forbidden",
    setup() {
        const userRoles = useAuthUserStore()?.user?.roles?.split(',');

        return {userRoles};
    }
}
</script>

<style scoped>

</style>
