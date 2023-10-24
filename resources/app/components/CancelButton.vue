<script>
    export default {
        name: 'cancel-button',
    }

</script>

<template>
    <a href="#" @click.prevent="$router.back()" class="btn ripple btn-secondary">{{ $t('forms.cancel') }}</a>
</template>
