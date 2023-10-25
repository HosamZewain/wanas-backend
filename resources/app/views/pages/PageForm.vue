<script setup>
import {getCurrentInstance, ref} from "vue";
import PageApi from "@api/pages.api";
import {ElMessage} from "element-plus";

const app = getCurrentInstance();
const t = app.appContext.config.globalProperties.$t;
const emit = defineEmits(["create", "update", "close"]);
const props = defineProps({
    resource: {
        type: Object,
        required: false,
    },
    openModal: {
        type: Boolean,
        required: false,
    },
    title: {
        type: String,
        required: false,
    },
})
let errors = ref([]);
let isSubmitted = ref(false);

async function submit() {

    isSubmitted.value = true;

    errors.value = [];

    props.resource.embed = "image";

    if (props.resource.id) {

        await update();

    } else {

        await save();
    }
}

async function save() {

    PageApi.store(props.resource)
    .then(({data}) => {
        ElMessage({
            message: t('messages.success'),
            type: 'success',
        });
        emit("create", data.data);
    })
    .catch(error => {
        ElMessage({
            message: t('messages.error'),
            type: 'error',
        });
        errors.value = error.response.data.errors
    }).finally(() => isSubmitted.value = false)
}

async function update() {
    
    PageApi.update(props.resource)
    .then(({data}) => {
        ElMessage({
            message: t('messages.success'),
            type: 'success',
        });
        emit("update", data.data);
    })
    .catch(error => {
        ElMessage({
            message: t('messages.error'),
            type: 'error',
        });
        errors.value = error.response.data.errors;
    }).finally(() => isSubmitted.value = false)
}

async function successUpload(data) {

    if (!props.resource[data.type]) {

        props.resource[data.type] = [];

        props.resource['image'] = [];
    }

    props.resource[data.type].push(data.id);
    
    props.resource['image'].push(data);
}

async function successDeleteUpload(data) {

    if (!props.resource[data.type])

        props.resource[data.type] = [];

    props.resource[data.type].splice(props.resource[data.type].indexOf(data.id), 1);
}

function close() {

    emit("close");

    errors.value = [];
}

</script>

<template>
    <el-dialog v-model="props.openModal" :title="props.title" @close="close">
        <el-form ref="ruleFormRef" :model="resource">
            <div class="row">
               
                <div class="col-md-12">
                    <FormInput :errors="errors" :model="resource" label="pages.title"
                            :required="true" name="title" title="pages.title"/>
                </div>

                <div class="col-md-12">
                    <FormEditor
                        :model="resource"
                        name="body"
                        :required="true"
                        :errors="errors"
                    />
                </div>
                
                <div class="col-md-12">
                    <FormFileUpload 
                        :accept="`.png,.jpeg,.jpg,.gif`"
                        :files="resource.image ? resource.image : []" :maxSize="'20480'"
                        :multiple="false"
                        type="page_image"
                        @successDeleteUpload="successDeleteUpload"
                        @successUpload="successUpload"
                    />
                </div>
            </div>
        </el-form>
        <hr>
        <span class="dialog-footer">
            <el-button :disabled="isSubmitted" class="btn btn-primary mt-2" type="primary" @click="submit()">
                {{ $t('forms.save') }}
            </el-button>
            <el-button class="btn btn-light mt-2" type="default" @click="close()">
                {{ $t('forms.cancel') }}
            </el-button>
        </span>
    </el-dialog>
</template>
