<script setup>
    import {useLoaderStore} from "@store/loader";

    const props = defineProps({
        style: {
            type: [String],
            default: "primary"
        }
    })
    const store = useLoaderStore();
</script>

<template>
    <div class="d-flex justify-content-center" v-if="store.loading">
        <div :class="`spinner-border text-${style}`" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</template>
