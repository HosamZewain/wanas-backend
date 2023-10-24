<script>
    export default {
        name: 'back-button',
    }

</script>

<template>
    <a href="#" class="text-secondary mx-2" @click.prevent="$router.back()">
        <i class="fas fa-arrow-right"></i>
    </a>
</template>
