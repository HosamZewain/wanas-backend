<script setup>
import {getCurrentInstance, onMounted, ref, shallowRef} from "vue";
import NotificationApi from "@api/notification.api";
import {useLoaderStore} from "@store/loader";
import {ElMessage} from "element-plus";
import {useAuthUserStore} from "@store/user";
import ConfirmBox from "@components/ConfirmBox.vue";

const loaderStore = useLoaderStore();
const app = getCurrentInstance();
const t = app.appContext.config.globalProperties.$t;
const resources = ref([]);
const store = useAuthUserStore();
let pagination = shallowRef({
    page: 1,
});
let filters = ref({
    page: 1,
    keyword: "",
    user: store.user.id,
});
const disabled = ref(false);

async function getResources(page = 1) {
    filters.value.page = page;
    filters.value.ofUser = true;
    NotificationApi.list(filters.value)
        .then(({data}) => {
            resources.value = data.data;
            pagination.value = data;
        })
        .catch((error) => {
            console.log(error);
            ElMessage({
                message: t("messages.error"),
                type: "error",
            });
        });
}

async function takeAction(action, resource) {
    disabled.value = true;
    NotificationApi.takeAction(resource, {action: action})
        .then(({data}) => {
            ElMessage({
                message: data.message,
                type: "success",
            });
            getResources();
        })
        .catch((error) => {
            console.log(error);
            ElMessage({
                message: t("messages.error"),
                type: "error",
            });
        })
        .then(() => {
            disabled.value = false;
        });
}

const deleteResource = async (selectedResource, index) => {
    await NotificationApi.delete(selectedResource)
        .then(async () => {
            resources.value.splice(index, 1);
            ElMessage({
                type: "success",
                message: "Delete completed",
            });
        })
        .catch((error) => {
            console.log(error);
        });
};

onMounted(async () => {
    await getResources();
});
</script>

<template>
    <div class="main-content side-content">
        <div class="container">
            <page-header title="sidebar.notifications"/>
            <div class="card">
                <div  v-for="(resource, index) in resources" v-if="resources.length" class="card-body p-0">
                    <div class="d-flex border-bottom p-3 bg-lightGray4">
                        <div class="flex-shrink-0">
                            <div
                                class="active-bell btn-icon bg-lightBlue2 rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fa-regular fa-bell text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3 noti-block">
                            <router-link :to="resource.data?.route ?? '/notifications'"
                                         class="d-flex align-items-center justify-content-between flex-wrap mb-3">
                                <span class="text-black fs-15">{{ resource.title }}</span>
                                <span class="badge badge-success fs-12 p-2 rounded-lg mw-100 text-capitalize w-fit-content">
                                    {{ resource.module }}
                                </span>
                            </router-link>
                            <router-link :to="resource.data?.route ?? '/notifications'" class="text-black fs-14 noti-body ps-2 mb-2">
                                {{ resource.body }}
                            </router-link>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="date text-grayClr">
                                    {{ resource.datetime }}
                                </div>
                                <ConfirmBox @confirmAction="deleteResource(resource, index)" v-if="hasPermission('delete', 'Notification')">
                                    <template #content>
                                        <a href="#" class="btn btn-icon btn-light-danger">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </template>
                                </ConfirmBox>
                            </div>
                            <div v-if="resource.data?.actions?.length && resource.data?.actionsEnabled
                                 && hasPermission(resource.data?.permission,resource.module)" class="d-flex mt-3">
                                <el-button v-for="(action, index) in resource.data?.actions"
                                    :key="index" :class="`btn btn-${action.color} fs-13 h-35px`"
                                    :disabled="disabled" :type="action.color" @click="takeAction(action.value, resource)">
                                    {{ action.label }}
                                </el-button>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else class="card-body d-flex justify-content-center flex-column align-items-center p-4">
                    <img :src="`${publicPath}/assets/images/no-noti.png`" alt="bell" width="120"/>
                    <h6 v-if="!resources.length && !loaderStore.loading" class="text-grayClr text-center mt-4 fw-bold mb-0">
                        {{ t('global.no_results') }}
                    </h6>
                </div>
            </div>
        </div>
    </div>
</template>
