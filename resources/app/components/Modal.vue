<template>
    <a :class="`${class_name}`" v-if="permission & showButton" data-bs-toggle="modal" data-bs-dismiss="modal"
       :data-bs-target="`${'#'+id}`" @click="this.$emit('openModal')">
        <span :class="icon_class + ' me-1'"></span>{{ use$T ? $t(title) : title }}
    </a>
    <div class="modal fade" :id="`${id}`" tabindex="-1" aria-labelledby="largeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="largeModalLabel">{{ use$T ? $t(title) : title }}</h5>
                    <slot name="title-button"></slot>
                    <button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close" @click="close"></button>
                </div>
                <div class="modal-body">
                    <slot name="body"></slot>
                </div>
                <div class="modal-footer">
                    <slot name="footer"></slot>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="close">{{ $t('forms.cancel') }}</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "modal",
    emits:["clearForm", "openModal"],
    props:{
        class_name:{
            type:String,
            default:''
        },
        title:{
            type:String,
            default:""
        },
        id:{
            type:String,
            default:''
        },
        permission:{
            type:Boolean,
            default:true
        },
        icon_class:{
            type:String,
            default:'fa fa-plus'
        },
        showButton:{
            type:Boolean,
            default:true
        },
        use$T:{
            type:Boolean,
            default:true
        }
    },
    methods:{
        close(){
            //in case of form
            this.$emit('clearForm');
        },
    },
    created(){
        $(document).on('hide.bs.modal', function () {
            $('.modal-backdrop').remove()
        });
    },
}
</script>

<style scoped>

</style>
