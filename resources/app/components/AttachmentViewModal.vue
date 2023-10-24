<script setup>
import {getCurrentInstance, ref} from "vue";

const app = getCurrentInstance();
const t = app.appContext.config.globalProperties.$t;
const emit = defineEmits([ "close"]);
const props = defineProps({
    file: {
        type: Object,
        required: false,
    },
    openModal: {
        type: Boolean,
        required: false,
    }
});
const imageExtensions = ref(['png', 'jpeg', 'jpg']);

function close() {
    emit("close");
}

</script>

<template>
    <el-dialog v-model="props.openModal" @close="close">
        <img v-if="imageExtensions.includes(file.ext)"
            :src="file.url"
            class="w-100"
            alt="attachment"
        />
        <iframe v-else
            :src="`${file.url}#toolbar=0&navpanes=0&scrollbar=0`"
            frameBorder="0"
            scrolling="auto"
            height="600px"
            width="100%"
        ></iframe>
    </el-dialog>
</template>
