<template>
    <label class="mb-2 w-100">{{$t(title)}}</label>
    <el-radio-group v-model="props.model[name]" class="mx-2">
        <el-radio v-for="item in props.values" :label="item.id">{{ $t('pages.'+item.name) }}</el-radio>
    </el-radio-group>
    <form-validation-errors :errors="props.errors" :name="name"/>
</template>

<script setup>

const props = defineProps({
    title: {
        type: String,
        default: ''
    },
    label: {
        type: String,
        default: ''
    },
    model: {
        type: [Array, Object],
    },
    name: {
        type: String,
        default: ''
    },
    errors: {
        type: [Array, Object],
        default: []
    },
    values: {
        type: [Array, Object],
        default: []
    }
});
</script>

<style scoped>

</style>
