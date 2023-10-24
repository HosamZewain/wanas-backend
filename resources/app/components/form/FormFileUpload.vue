<script setup>
import FileApi from "@api/file.api";
import {ElMessage} from "element-plus";
import {getCurrentInstance, ref} from "vue";
import FilePreview from "@components/FilePreview.vue";
import { UploadFilled } from '@element-plus/icons-vue'

const app = getCurrentInstance();
const t = app.appContext.config.globalProperties.$t;
const fileContent = ref('');
let showPreview = ref(false);
const errors = ref([]);

const uploadPercentage = ref(0);
const uploadStatus = ref('');
const uploadFileName = ref('');
const startUpload = ref(false);


const props = defineProps({
    type: {
        type: String,
        required: true
    },
    multiple: {
        type: Boolean,
        default: false
    },
    accept: {
        type: String,
        // default:  `.text,.txt,.pdf,.png,.jpeg, .jpg,.doc,.docx,.xlsx,.xls`,
        default:  '',
    },
    maxSize: {
        type: String,
        default:  `5120`,
    },
    limit: {
        type: Number,
        default: 1
    },
    data: {
        type: Array,
        default: () => []
    },
    files: {
        type: Array,
        default: () => []
    },
    size: {
        type: Number,
        default: 20
    }
})

const emit = defineEmits(['successUpload', 'successDeleteUpload']);

const config = (event)=>{
    return {
        onUploadProgress(progressEvent) {
            startUpload.value = true;
            const { loaded, total } = progressEvent;
            let percent = Math.floor((loaded * 100) / total);
            uploadFileName.value = event.file?.name??''
            // console.log(`${loaded} bytes of ${total} bytes. ${percent}%`);
            if (percent < 100) {
                uploadPercentage.value =  percent;
            }
        }
    }
}

async function handleUpload(event) {
    let formData = new FormData();
    formData.append('type', props.type);
    formData.append('file', event.file);
    formData.append('accept', props.accept);
    formData.append('maxSize', props.maxSize);
    if (props.data.length > 0) {
        props.data.forEach((item) => {
            formData.append(item.name, item.value);
        })
    }

    FileApi.store(formData,config(event))
        .then(({data})=>{
            uploadStatus.value = 'success'
            emit('successUpload', data.data);
            ElMessage({
                message: t('messages.success'),
                type: 'success',
            })
        })
        .catch(error => {
            uploadStatus.value = 'exception'
            errors.value = error.response.data.errors;
            ElMessage({
                message: t('messages.error'),
                type: 'error',
            })
            console.log(error);
        })
        .finally(()=>{
            startUpload.value = false;
            uploadStatus.value = ''
            uploadFileName.value = ''
            uploadPercentage.value =  0;
        })
}

async function deleteFile(file)
{
    props.files.splice(props.files.indexOf(file), 1);
    FileApi.delete(file)
        .then(({data}) => {
            emit('successDeleteUpload', file);
            ElMessage({
                message: t('messages.success'),
                type: 'success',
            })
        })
        .catch(error => {
            ElMessage({
                message: t('messages.error'),
                type: 'error',
            })
            console.log(error);
        })
}
async function previewFile(file)
{
    FileApi.get(file)
        .then(({data}) => {
            fileContent.value = data
            showPreview.value = true;
        })
        .catch(error => {
            ElMessage({
                message: t('messages.error'),
                type: 'error',
            })
            console.log(error);
        })
}

const switchPreview = () => {
    showPreview.value = !showPreview.value;
}
</script>
<template>
    <el-upload :http-request="handleUpload"
               :limit="multiple ? 10 : limit"
               :multiple="multiple"
               :show-file-list="false"
               :accept="accept"
               class="upload-demo"
               drag>
        <el-icon class="el-icon--upload">
            <upload-filled/>
        </el-icon>
        <div class="el-upload__text">
            {{ $t('pages.file_upload_text') }} <em>{{ $t('pages.click_to_upload') }}</em>
        </div>
        <template #tip>
            <div class="el-upload__tip">
                {{ $t('pages.file_upload_img_hint')}} <em>{{props.size}} {{ $t('pages.mega') }}</em>
            </div>
        </template>
    </el-upload>
    <div class="demo-progress" v-if="startUpload">
        <el-form-item :label="uploadFileName" class="mb-0"/>
        <el-progress :percentage="uploadPercentage" :status="uploadStatus"/>
    </div>
    <form-validation-errors :errors="errors"  name="file"/>

    <div v-if="files.length > 0">
        <ul class="el-upload-list el-upload-list--text">
            <li class="el-upload-list__item is-success" tabindex="0" v-for="file in files">
                <div class="el-upload-list__item-info">
                    <a class="el-upload-list__item-name" @click="previewFile(file)">
                        <i class="el-icon el-icon--document">
                            <svg viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M832 384H576V128H192v768h640V384zm-26.496-64L640 154.496V320h165.504zM160 64h480l256 256v608a32 32 0 0 1-32 32H160a32 32 0 0 1-32-32V96a32 32 0 0 1 32-32zm160 448h384v64H320v-64zm0-192h160v64H320v-64zm0 384h384v64H320v-64z"
                                    fill="currentColor"></path>
                            </svg>
                        </i>
                        <span class="el-upload-list__item-file-name">{{file.name}}</span>
                    </a>
                </div>
                <label class="el-upload-list__item-status-label">
                    <i class="el-icon el-icon--upload-success el-icon--circle-check">
                        <svg viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                            <path d="M512 896a384 384 0 1 0 0-768 384 384 0 0 0 0 768zm0 64a448 448 0 1 1 0-896 448 448 0 0 1 0 896z"
                                  fill="currentColor">
                            </path>
                            <path
                                d="M745.344 361.344a32 32 0 0 1 45.312 45.312l-288 288a32 32 0 0 1-45.312 0l-160-160a32 32 0 1 1 45.312-45.312L480 626.752l265.344-265.408z"
                                fill="currentColor"></path>
                        </svg>
                    </i>
                </label>
                <i class="el-icon el-icon--close" @click="deleteFile(file)">
                    <svg viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                        <path d="M764.288 214.592 512 466.88 259.712 214.592a31.936 31.936 0 0 0-45.12 45.12L466.752 512 214.528 764.224a31.936 31.936 0 1 0 45.12 45.184L512 557.184l252.288 252.288a31.936 31.936 0 0 0 45.12-45.12L557.12 512.064l252.288-252.352a31.936 31.936 0 1 0-45.12-45.184z"
                              fill="currentColor">
                        </path>
                    </svg>
                </i>
                <i class="el-icon--close-tip">press delete to remove</i>
            </li>
        </ul>
    </div>
    <FilePreview v-if="fileContent" :src="`data:${fileContent.mime};base64,${fileContent.data}`"
                 :fileData="fileContent" :showPreview="showPreview"/>
</template>

<style scoped>
.demo-progress .el-progress--line {
    margin-bottom: 15px;
    width: 350px;
}
</style>
