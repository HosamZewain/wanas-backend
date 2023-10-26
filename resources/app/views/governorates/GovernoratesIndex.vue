<script setup>
import { ref, shallowRef, onMounted, getCurrentInstance } from "vue";
import GovernorateApi from "@api/governorate.api";
import GovernorateForm from "@views/governorates/GovernorateForm.vue";
import { Plus } from "@element-plus/icons-vue";
import ConfirmBox from "@components/ConfirmBox.vue";
import { ElMessage } from "element-plus";
import FormHelper from "@mixins/form";
import {useLoaderStore} from "@store/loader";
import { useRoute } from "vue-router";
import FilterApi from "@api/filter.api";

const loaderStore = useLoaderStore();
const app = getCurrentInstance();
const t = app.appContext.config.globalProperties.$t;
const route = useRoute();
let resources = ref([]);
let countries = ref([]);
let title = ref("");
let openModal = ref(false);
const resource = ref({});
let pagination = shallowRef({
    page: 1,
});
let filters = ref({
    page: 1,
    keyword: "",
    embed: "country"
});

async function getModuleRelatedData() {
    FilterApi.modelFilters("Governorate")
    .then(({ data }) => {
        countries.value = data.countries;
    })
    .catch((error) => {
        console.log(error);
    });
}

async function getResources(page = 1) {
    
    filters.value.page = page;

    GovernorateApi.list(filters.value)
    .then(({ data }) => {
        resources.value = data.data;
        pagination.value = data.meta;
    })
    .catch((error) => {
        console.log(error);
    });
}

const deleteResource = async (selectedResource) => {

    await GovernorateApi.delete(selectedResource)
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
    title.value = t("pages.add_new_governorate");
};

const openUpdateModal = (model) => {
    openModal.value = true;
    title.value = t("pages.edit_governorate");
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
    await getModuleRelatedData();
});

</script>
<template>
    <div class="main-content side-content">
        <div class="container">
            <page-header title="sidebar.pages">
                <template v-slot:button>
                    <el-button type="primary" class="btn btn-primary" :icon="Plus"
                        @click="openCreateModal()" v-if="hasPermission('create', 'Governorate')">
                        {{ $t("pages.add_new_governorate") }}
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
                <el-table-column :label="$t('pages.name_ar')">
                    <template #default="scope">
                        <div class="text-dark fw-bold">
                            {{ scope.row.name_ar }}
                        </div>

                        <div>
                            <a @click="openUpdateModal(scope.row)" v-if="hasPermission('update', 'Governorate')">
                                <span class="me-2 text-primary text-underline">
                                    {{ $t("forms.edit") }}
                                </span>
                            </a>
                            <ConfirmBox
                                v-if="hasPermission('delete', 'Governorate')"
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
                <el-table-column :label="$t('pages.name_en')" prop="name_en"/>
                <el-table-column :label="$t('pages.country')" prop="country.name"/>
            </el-table>
            <strong v-if="!resources.length && !loaderStore.loading" class="text-danger">
                {{ $t("global.no_results") }}
            </strong>
            <Pagination :pagination="pagination" @paginate="getResources" />
        </div>

        <GovernorateForm
            v-if="openModal"
            :openModal="openModal"
            :title="title"
            :countries="countries"
            :resource="resource"
            @close="close"
            @create="afterCreate"
            @update="afterUpdate"
        />

    </div>
</template>
