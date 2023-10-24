<template>
    <label class="mb-2 w-100">{{$t(props.title)}}</label>
    <el-checkbox v-for="(item, index) in props.values" v-model="props.model[item]">{{ $t('pages.'+item) }}</el-checkbox>
    <form-validation-errors v-for="item in props.values" :errors="errors" :name="item.name"/>
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
})

</script>

<style scoped>

</style>
