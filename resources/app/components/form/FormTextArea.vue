<template>
    <label>{{$t(label)}}</label>
    <textarea :class="errors[name] ? 'form-control is-invalid' : 'form-control'"
              v-model="model[name]" :placeholder="$t('placeholder') + $t(label)"
           @keydown.stop="clearError"></textarea>
    <form-validation-errors :errors="errors" :name="name"/>
</template>

<script>
export default {
    name: "FormTextArea",
    emits:['clearErrors'],
    props: {
        label:{
            type:String,
            default:''
        },
        model: {
            type: [Array, Object, String],
        },
        name:{
            type:String,
            default:''
        },
        errors:{
            type: [Array, Object],
            default:[]
        }
    },
    methods: {
        clearError(){
            this.$emit('clearErrors', this.name)
        },
    },
}
</script>

<style scoped>

</style>
