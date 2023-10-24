<script setup>
import { ref, shallowRef, onMounted } from "vue";
import RoleApi from "@api/role.api";
import {useLoaderStore} from "@store/loader";
import ConfirmBox from "@components/ConfirmBox.vue";

const loaderStore = useLoaderStore();
let roles = shallowRef([]);
let permissions = shallowRef([]);
let openPermissionModal = shallowRef(false);
let title = shallowRef("");
let filters = ref({
    page: 1,
    embed: "permissions",
});
let pagination = shallowRef({
    page: 1,
});

async function getRoles(page = 1) {
    filters.value.page = page;
    RoleApi.list(filters.value)
        .then(({ data }) => {
            roles.value = data.data;
            pagination = data.meta;
        })
        .catch((error) => {
            console.log(error);
        });
}

const viewPermission = (selectedResource) => {
    title.value = "pages.permission";
    Object.assign(permissions, selectedResource.permissions);
    openPermissionModal.value = true;
};

const deleteResource = async (selectedResource) => {
    await RoleApi.delete(selectedResource)
        .then(async () => {
            await getRoles();
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
    await getRoles();
});
</script>

<template>
    <div class="main-content side-content">
        <div class="container">
            <page-header title="sidebar.roles">
                <template v-slot:button>
                    <router-link
                        v-if="hasPermission('create', 'Role')"
                        class="btn btn-primary"
                        to="/roles/create"
                    >
                        <i class="fas fa-plus me-2 fs-13 text-babyblue"></i>
                        {{ $t("pages.add_new_role") }}
                    </router-link>
                </template>
            </page-header>

            <div class="card">
                <div class="card-body pb-0">
                    <Filters @submit="getRoles" :model="filters" />
                </div>
            </div>
            <spinner/>
            <el-table :data="roles" style="width: 100%" v-if="roles.length">
                <el-table-column label="#" type="index" />
                <el-table-column :label="$t('pages.name')">
                    <template #default="scope">
                        <router-link to="/roles" class="text-dark fw-bold">
                            {{ scope.row.name }}
                        </router-link>
                        <div>
                            <router-link
                                :to="'/roles/show/' + scope.row.id"
                                v-if="hasPermission('read', 'Role')"
                            >
                                <span class="me-2 text-primary text-underline">
                                    {{ $t("forms.permissions") }}
                                </span>
                            </router-link>
                            -
                            <router-link
                                :to="'/roles/edit/' + scope.row.id"
                                v-if="hasPermission('update', 'Role')"
                            >
                                <span class="me-2 text-primary text-underline">
                                    {{ $t("forms.edit") }}
                                </span>
                            </router-link>
                            -
                            <ConfirmBox @confirmAction="deleteResource(scope.row, scope.$index)"
                                        v-if="hasPermission('delete', 'Role') && scope.row.can_be_deleted">
                                <template #content>
                                    <a href="javascript:void(0)" class="text-primary text-underline">
                                        {{ $t("forms.delete") }}
                                    </a>
                                </template>
                            </ConfirmBox>
                        </div>
                    </template>
                </el-table-column>
            </el-table>
            <strong
                v-if="!roles.length && !loaderStore.loading"
                class="text-danger"
                >{{ $t("global.no_results") }}</strong
            >
            <Pagination :pagination="pagination" @paginate="getRoles" />
        </div>
    </div>
</template>
