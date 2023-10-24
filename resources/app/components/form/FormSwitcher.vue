<template>
    <label class="w-100 my-2">{{$t(props.title)}}</label>
    <el-switch v-model="props.model[name]" ></el-switch>
    <form-validation-errors :errors="props.errors" :name="props.name"/>
</template>

<script setup>


const props = defineProps({
    title:{
        type:String,
        default:''
    },
    label:{
        type:String,
        default:''
    },
    model: {
        type: [Array, Object],
    },
    name:{
        type:String,
        default:''
    },
    errors:{
        type: [Array, Object],
        default:[]
    }
})

</script>

<style scoped>

</style>
