<template>
    <form-modal :permission="hasPermission('create', 'Note')"
                @clearForm="clearForm" @submit="submit"
                id="noteForm" :buttonDisabled="submitFormDisabled">
        <form-input label="pages.name" type="text"
                    :model="this.$parent.note" name="content" :errors="formErrors" @clearErrors="clearInput"/>
    </form-modal>
</template>

<script>
import {useToast} from "vue-toastification";
import NoteApi from "@api/note.api";

export default {
    name: "NoteForm",
    methods: {
        submit()
        {
            this.submitFormDisabled = true;
            let id = this.$parent.note.id;
            if (id){
                this.updateNote(id);
            }else{
                this.saveNote()
            }
        },
        clearForm()
        {
            this.resetForm(this.$parent.note);
            this.clearErrors();
        },
        saveNote()
        {
            this.$parent.note.visible = 1;
            NoteApi.store(this.$parent.note)
                .then(({data}) => {
                    useToast().success(this.$t('messages.success'))
                    this.submitFormDisabled = false;
                    $('#noteForm').modal('hide');
                    this.afterModalAddActions(this.$parent.note, this.$parent.notes, data.data)
                })
                .catch(error => {
                    console.log(error);
                    this.formErrors = error.response.data.errors;
                })
        },
        updateNote(id)
        {
            this.$parent.note.visible = 1;
            NoteApi.update(this.$parent.note)
                .then(({data}) => {
                    useToast().success(this.$t('messages.success'))
                    this.submitFormDisabled = false;
                    $('#noteForm').modal('hide');
                    this.afterModalUpdateActions(this.$parent.note, this.$parent.notes, data.data, id)
                })
                .catch(error => {
                    console.log(error);
                    this.formErrors = error.response.data.errors;
                })
        }
    },
}
</script>

<style scoped>

</style>
