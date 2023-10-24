<template>
    <a @click="openDeleteModal()">
        <span class="me-2 text-primary text-underline">
            {{ $t('forms.delete') }}
        </span>
    </a>
</template>

<script setup>
import { ElMessage, ElMessageBox } from 'element-plus'
const emit = defineEmits(["delete"]);
const props = defineProps({
    'icon': {
        type: Boolean,
        default: true
    },
    'btnText': {
        type: Boolean,
        default: false
    },
    'size': {
        type: String,
        default: 'sm'
    },
})

const openDeleteModal = async () => {
    ElMessageBox.confirm(
        'proxy will permanently delete the file. Continue?',
        'Warning',
        {
            confirmButtonText: 'OK',
            cancelButtonText: 'Cancel',
            type: 'warning',
        }
    )
        .then(async () => {
            emit("delete");
        })
        .catch(() => {
            ElMessage({
                type: 'info',
                message: 'Delete canceled',
            })
        })
}
</script>
