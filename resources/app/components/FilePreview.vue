<script setup>

const props = defineProps({
    showPreview: {
        type: Boolean,
        required: true,
        default: false
    },
    src: {
        type: String,
        required: true
    },
    fileData: {
        type: Object,
        required: true
    }
})

async function downloadFile() {
    let link = document.createElement('a');
    link.href = props.src;
    link.download = props.fileData?.name;
    link.click();
}

</script>
<template>
    <el-dialog v-model="props.showPreview" draggable title="Preview" top="3vh" width="70%" @close="showPreview = false">
        <embed v-if="fileData?.mime === 'application/pdf'" :src="src" height="600px" type="application/pdf" width="100%">
        <img v-else-if="fileData?.mime?.startsWith('image')" :src="src" alt="Preview" class="img-fluid">
        <span v-else>
            {{ $t('pages.preview_not_available') }}
            <a class="text-underline text-primary" href="#" @click="downloadFile"> {{ $t('pages.download') }} </a>
        </span>
    </el-dialog>
</template>

<style scoped>

</style>
