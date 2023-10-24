<template>
    <div class="page-header">
        <div>
            <h2 class="main-content-title">{{ $t(title) }}</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page">

                        <router-link :to="{name: 'dashboard'}">
                            {{ $t('sidebar.dashboard') }}
                        </router-link> 
                    </li> 
                    <li :class="active ? 'breadcrumb-item active' : 'breadcrumb-item'" aria-current="page">
                        <span v-if="active">{{ $t(title) }}</span>
                        <a v-else @click="$router.back()">{{ $t(title) }}</a>
                    </li>
                    <slot></slot>
                </ol>
            </nav>
        </div>
        <slot name="button"></slot>
    </div>
</template>

<script>
import { useAuthUserStore } from "@store/user";
import { onMounted, ref } from "vue";

export default {
    name: "PageHeader",
    props:{
        title:{
            type:String,
            default:''
        },
        active:{
            type:Boolean,
            default:true
        },
        withButton:{
            type:Boolean,
            default:false
        },
        btnText:{
            type:String,
            default:''
        },
        btnActionPermission:{
            type:String,
            default:''
        },
        btnModulePermission:{
            type:String,
            default:''
        }
    },
    setup() {
        const store = useAuthUserStore();
        const authUserRoles = store.user.roles.split(',');
    }
}
</script>

<style scoped>

</style>
