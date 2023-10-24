<template>
    <el-popconfirm confirm-button-text="Yes" cancel-button-text="No" :icon="InfoFilled"
        :title="props.title" @confirm="confirmAction">
        <template #reference>
            <slot name="content"></slot>
        </template>
    </el-popconfirm>
</template>

<script setup>
import {InfoFilled} from "@element-plus/icons-vue";

const emit = defineEmits(["confirmAction"]);
const props = defineProps({
    title: {
        type: String,
        default: "Are you sure?"
    }
});

const confirmAction = () => {
    emit("confirmAction");
}


</script>

<style scoped>

</style>
