<template>
    <div class="modal fade" :id="`${id}`" :data-bs-target="`#${id}`" tabindex="-1" aria-labelledby="largeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="largeModalLabel">{{ $t(title) }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ref="closeModal" @click="close"></button>
                </div>
                <div class="modal-body">
                    <slot name="body"></slot>
                </div>
                <div class="modal-footer" v-if="hasSlot('footer')">
                    <slot name="footer"></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {useSlots} from "vue";

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
            default:''
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
        }
    },
    methods:{
        hasSlot(name = "default") {
            const slots = useSlots();
            return !!slots[name];
        },
        close(){
            //in case of form
            this.$emit('clearForm');
        }
    },
    created(){
        $(document).on('hide.bs.modal', function () {
            $('.modal-backdrop').remove()
        });
    }
}
</script>

<style scoped>

</style>
