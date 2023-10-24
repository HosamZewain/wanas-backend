<script setup>
import { ref, shallowRef, onMounted, getCurrentInstance } from "vue";
import VehiclesTypeApi from "@api/vehiclesType.api";
import VehiclesTypeForm from "@views/vehiclesTypes/VehiclesTypesForm.vue";
import { Plus } from "@element-plus/icons-vue";
import ConfirmBox from "@components/ConfirmBox.vue";
import { ElMessage } from "element-plus";
import FormHelper from "@mixins/form";
import {useLoaderStore} from "@store/loader";
import { useRoute } from "vue-router";

const loaderStore = useLoaderStore();
const app = getCurrentInstance();
const t = app.appContext.config.globalProperties.$t;
const route = useRoute();
let resources = ref([]);
let title = ref("");
let openModal = ref(false);
const resource = ref({});
let pagination = shallowRef({
    page: 1,
});
let filters = ref({
    page: 1,
    keyword: "",
    embed: "logo"
});

async function getResources(page = 1) {
    
    filters.value.page = page;

    VehiclesTypeApi.list(filters.value)
    .then(({ data }) => {
        resources.value = data.data;
        pagination.value = data.meta;
    })
    .catch((error) => {
        console.log(error);
    });
}

const deleteResource = async (selectedResource) => {

    await VehiclesTypeApi.delete(selectedResource)
    .then(async () => {
        await getResources();
        ElMessage({
            type: "success",
            message: "Delete completed",
        });
    })
    .catch((error) => {
        console.log(error);
    });
};

const openCreateModal = () => {
    openModal.value = true;
    title.value = t("pages.add_new_vehicle");
};

const openUpdateModal = (model) => {
    openModal.value = true;
    title.value = t("pages.edit_vehicle");
    resource.value = _.cloneDeep(model);
};

const close = () => {
    openModal.value = false;
    FormHelper.resetForm(resource.value);
};

async function afterCreate(resource) {
    resources.value.unshift(resource);
    openModal.value = false;
    close();
}

async function afterUpdate(resource) {
    await FormHelper.updateGrid(resources.value, resource, resource.id);
    openModal.value = false;
    close();
}

onMounted(async () => {
    await getResources();
});

</script>
<template>
    <div class="main-content side-content">
        <div class="container">
            <page-header title="sidebar.vehicles_types">
                <template v-slot:button>
                    <el-button type="primary" class="btn btn-primary" :icon="Plus"
                        @click="openCreateModal()" v-if="hasPermission('create', 'VehiclesType')">
                        {{ $t("pages.add_new_vehicle") }}
                    </el-button>
                </template>
            </page-header>
            <div class="card">
                <div class="card-body pb-0">
                    <Filters @submit="getResources" :model="filters"/>
                </div>
            </div>
            <spinner/>
            <el-table :data="resources" style="width: 100%" v-if="resources.length">
                <el-table-column label="#" type="index" />
                <el-table-column :label="$t('pages.name')">
                    <template #default="scope">
                        <div class="text-dark fw-bold">
                            {{ scope.row.name }}
                        </div>

                        <div>
                            <a @click="openUpdateModal(scope.row)" v-if="hasPermission('update', 'VehiclesType')">
                                <span class="me-2 text-primary text-underline">
                                    {{ $t("forms.edit") }}
                                </span>
                            </a>
                            <ConfirmBox
                                v-if="hasPermission('delete', 'VehiclesType')"
                                @confirmAction="deleteResource(scope.row, scope.$index)">
                                <template #content>
                                    <a href="javascript:void(0)" class="me-2 text-primary text-underline">
                                        {{ $t("forms.delete") }}
                                    </a>
                                </template>
                            </ConfirmBox>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column :label="$t('pages.logo')">
                    <template #default="scope">
                        <img
                            :src="scope.row.logo?.url ?? defaultUserImage"
                            class="img-fluid"
                            width="50"
                            height="50"
                            alt=""
                        />
                    </template>
                </el-table-column>
            </el-table>
            <strong v-if="!resources.length && !loaderStore.loading" class="text-danger">
                {{ $t("global.no_results") }}
            </strong>
            <Pagination :pagination="pagination" @paginate="getResources" />
        </div>

        <VehiclesTypeForm
            v-if="openModal"
            :openModal="openModal"
            :title="title"
            :resource="resource"
            @close="close"
            @create="afterCreate"
            @update="afterUpdate"
        />

    </div>
</template>
