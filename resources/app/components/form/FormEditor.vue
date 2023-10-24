<script setup>
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import {ref} from "vue";

const props = defineProps({
    label: {
        type: String,
        default: ''
    },
    model: {
        type: [Array, Object]
    },
    name: {
        type: String,
        default: ''
    },
    errors: {
        type: [Array, Object],
        default: []
    },
    required:{
        type:Boolean,
        default:false
    }
})

ClassicEditor
    .create( document.querySelector( '#editor' ) )
    .then( editor => {
        window.editor = editor;
    } )
    .catch( error => {
        console.error( 'There was a problem initializing the editor.', error );
    } );
const editor = ref(ClassicEditor);
const editorConfig = ref({
    toolbar: {
        items: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList',
            'numberedList', 'blockQuote',
            'undo', 'redo', 'insertImage']
    },
    table: {
        contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
    }
});

</script>

<template>
    <el-form-item :label="$t(props.label)" class="mb-0" prop="name" :required="required">
    </el-form-item>

    <ckeditor :editor="editor" v-model="props.model[name]" :config="editorConfig"></ckeditor>
    <form-validation-errors :errors="props.errors" :name="props.name" />
</template>

<style scoped>

</style>
