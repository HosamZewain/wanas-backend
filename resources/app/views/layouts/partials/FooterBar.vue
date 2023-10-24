<script setup>
import {ref} from "vue";

const name = ref('footer-bar');
const appName = ref(import.meta.env.VITE_VUE_APP_NAME);

</script>

<template>
    <div class="main-footer text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                  <span>Copyright © 2021 {{appName}} . Designed by
                      <a href="https://www.roqay.com/">Roqay</a>
                      All rights reserved.</span>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
</style>
