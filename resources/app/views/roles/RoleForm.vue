<script setup>
import {shallowRef, onMounted, reactive, ref} from "vue";
import RoleApi from "@api/role.api";
import PermissionApi from "@api/permission.api";
import PermissionCard from "./PermissionCard.vue";
import { useRouter, useRoute } from "vue-router";
import FormInput from "@components/form/FormInput.vue";
import FormHelper from "@mixins/form";
import { useToast } from "vue-toastification";
import FilterApi from "@api/filter.api";
import {useI18n} from "vue-i18n";

const redirectRouter = useRouter();
const route = useRoute();
const {t} = useI18n();
const isUpdateForm = route.params?.id ? true : false;
let errors = reactive([]);

let isReadonly = shallowRef(false);
let cloneMode = ref(false);
let cloneTitle = ref(t("global.clone_permissions"));
let form = reactive({
    name: "",
    role_permissions: {},
});
let role = reactive({});
let system_permissions = shallowRef([]);
const toast = useToast();

const getRole = async () => {
    await RoleApi.get({ id: route.params.id }).then(({ data }) => {
        role = data.data;
        Object.assign(form, role);
        if (role.id == 1 || route.name == "role-show") isReadonly.value = true;
    });
};

const getSystemPermissions = async () => {
    await PermissionApi.list().then(({ data }) => {
        system_permissions.value = data;
    });
};

const submit =  async () => {
    if (isUpdateForm) {
        RoleApi.update(form)
            .then(() => {
                toast.success(`updated successfully`);
                redirectRouter.push({ name: "roles" });
            })
            .catch((error) => {
                FormHelper.prepareValidations(error.response.data.errors);
                errors.value = FormHelper.formErrors;
            });
    } else {
        RoleApi.store(form)
            .then(() => {
                toast.success(`created successfully`);
                redirectRouter.push({ name: "roles" });
            })
            .catch((error) => {
                FormHelper.prepareValidations(error.response.data.errors);
                errors.value = FormHelper.formErrors;
            });
    }
};

const clonePermissions =  async () => {
    RoleApi.store(form)
        .then(() => {
            toast.success(`created successfully`);
            redirectRouter.push({ name: "roles" });
        })
        .catch((error) => {
            FormHelper.prepareValidations(error.response.data.errors);
            errors.value = FormHelper.formErrors;
        });

};
const enableCloneMode =  async () => {
    form.new_name = '';
    cloneMode.value= !cloneMode.value;
    if(cloneMode.value){
        cloneTitle.value = t("forms.cancel")
    }else{
        cloneTitle.value = t("global.clone_permissions")
    }
}
onMounted(async () => {
    if (isUpdateForm) {
        await getRole();
    }
    await getSystemPermissions();
});
</script>

<template>
    <div class="main-content side-content">
        <div class="container">
            <page-header title="sidebar.roles" :active="false">
                <li
                    class="breadcrumb-item active"
                    aria-current="page"
                    v-if="route.name != 'role-show'"
                >
                    {{
                        isUpdateForm
                            ? $t("pages.edit_role")
                            : $t("pages.add_new_role")
                    }}
                </li>
                <li class="breadcrumb-item active" aria-current="page" v-else>
                    {{ $t("pages.read_role") }}
                </li>
            </page-header>

            <div class="py-2">
                <div class="card rounded border-0 shadow-sm mt-4">
                    <div class="card-body pb-0">
                        <el-form ref="ruleFormRef" :model="form" class="row">
                            <div class="col-md-3">
                                <FormInput
                                    label="pages.name"
                                    :model="form"
                                    name="name"
                                    :errors="errors.value"
                                    :disabled="isReadonly || cloneMode"
                                />
                            </div>
                            <div class="col-md-3" v-if="isUpdateForm && cloneMode">
                                <FormInput
                                    label="pages.new_name"
                                    :model="form"
                                    name="new_name"
                                    :errors="errors.value"
                                    :disabled="isReadonly"
                                />
                            </div>
                            <div class="col-md-3" v-if="isUpdateForm">
                                <!-- <el-button v-if="cloneMode" type="primary" class="btn btn-primary mt-4"
                                           @click.prevent="clonePermissions">
                                    {{ $t("global.clone_permissions") }}
                                </el-button> -->
                                <el-button v-if="cloneMode" type="info" class="btn btn-dark mt-4" @click.prevent="enableCloneMode">
                                    {{cloneTitle}}
                                </el-button>
                            </div>

                        </el-form>

                    </div>
                </div>

                <div class="mb-3 row">
                    <div
                        class="col-md-3"
                        v-for="(model_permissions, index) in system_permissions"
                        :key="index"
                    >
                        <PermissionCard
                            :permissions="model_permissions"
                            :group-title="index"
                            v-model="form.role_permissions"
                            :readonly="isReadonly"
                        />
                    </div>
                </div>

                <div :hidden="isReadonly" v-if="!cloneMode">
                    <el-button type="primary" @click="submit()">
                        {{ $t("forms.save") }}
                    </el-button>
                </div>
            </div>
        </div>
    </div>
</template>
