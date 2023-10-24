<template>
    <modal @clearForm="this.$emit('clearForm')" @openModal="this.$emit('openModal')">
        <template v-slot:title-button v-if="titleButton">
            <button :title="$t('save')" :disabled="buttonDisabled" type="button"
                class="btn text-success fs-5 ms-auto" @click.prevent="save">
                <span class="fa fa-check"></span>
            </button>
        </template>
        <template v-slot:body>
            <form>
                <slot></slot>
            </form>
        </template>
        <template v-slot:footer>
            <button :disabled="buttonDisabled" type="button" class="btn btn-primary" @click.prevent="save">{{
                $t('forms.save')
                }}</button>
        </template>
    </modal>
</template>

<script>
export default {
    name: "FormModal",
    emits: ["submit", 'clearForm', 'openModal'],
    props: {
        buttonDisabled: {
            type: Boolean,
            default: true
        },
        titleButton: {
            type: Boolean,
            default: false
        },
    },
    methods: {
        save() {
            this.$emit('submit')
        },
    }
}
</script>

<style scoped>

</style>
