<template>
    <div :class="`col-md-${size} my-1 d-flex flex-wrap`">
        <div class="col-lg-6 p-0">
            <h6 class="label mb-0"> {{ $t(title) }} :</h6>
        </div>
        <div class="col-lg-6 p-0">
            <div class="value">
                {{ value }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "KeyValuePoint",
    props:{
        title:{
            type:String,
            default:''
        },
        value:{
            type:[String, Number],
        },
        size:{
            type:Number,
            default:12
        }
    }
}
</script>

<style scoped>

</style>
