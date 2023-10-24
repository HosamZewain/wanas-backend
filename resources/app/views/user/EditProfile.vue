<script setup>
import {useToast} from "vue-toastification"
import {useAuthUserStore} from "@store/user";
import {getCurrentInstance, onMounted, reactive, ref} from "vue";
// import EmployeeApi from "@api/employee.api";

const app = getCurrentInstance();
const t = app.appContext.config.globalProperties.$t;
const userStore = useAuthUserStore()
const embed = 'user.roles,user.permissions,avatar,user.employee.user,user.employee.avatar'
const resource = ref({
    user: {}
});
let errors = reactive({})
const disabled = ref(false)

async function submit() {
    disabled.value = true
    resource.value.embed = embed
    // EmployeeApi.updateProfile(resource.value)
    //     .then(resp => {
    //         userStore.setUserData(resp.data.data.user)
    //         resource.value = resp.data.data
    //         useToast().success(t('messages.success'));
    //         disabled.value = false
    //     })
    //     .catch(error => {
    //         errors.value = error.response.data.errors
    //         disabled.value = false
    //     });
}

async function getResource()
{
    resource.value.id = userStore.getUserData.employee.id
    console.log(resource.value.id)
    // EmployeeApi.get(resource.value, {embed: embed})
    //     .then(resp => {
    //         resource.value = resp.data.data
    //     })
    //     .catch(error => {
    //         errors.value = error.response.data.errors
    //         disabled.value = false
    //     });
}

function successUpload(file) {
    resource.value.avatar = file
    resource.value.employee_avatar = file.id
}

function successDeleteUpload() {
    resource.value.avatar = null
    resource.value.employee_avatar = null
}

onMounted(async () => {
    await getResource()
})
</script>

<template>
    <div class="main-content side-content">
        <div class="container">
            <page-header title="sidebar.profile" :active="false">
                <li class="breadcrumb-item active" aria-current="page">{{ $t('pages.edit_profile') }}</li>
            </page-header>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card custom-card">
                        <div class="card-header rounded-bottom-0 my-3">
                            <div class="card-body">
                                <form class="d-flex flex-column">
                                    <div class="mb-3">
                                        <form-input label="pages.name" type="text" errorsName="user.name_en"
                                                    :model="resource.user" name="name_en" :errors="errors"/>
                                    </div>
                                    <div class="mb-3">
                                        <form-input label="pages.name_ar" type="text" errorsName="user.name_ar"
                                                    :model="resource.user" name="name_ar" :errors="errors"/>
                                    </div>
                                    <div class="mb-3">
                                        <form-input label="pages.email" type="email" errorName="user.email"
                                                    :model="resource" name="email" :disabled="true" :errors="errors"/>
                                    </div>
                                    <div class="mb-3">
                                        <form-input label="pages.birth_date" type="date"
                                                    :model="resource" name="date_of_birth" :errors="errors"/>
                                    </div>
                                    <div class="mb-3" >
                                        <form-input label="pages.phone" type="number" errorName="user.phone"
                                                    :model="resource.user" name="phone" :errors="errors"/>
                                    </div>
                                    <div class="mb-3">
                                        <label class="mb-2">{{ $t("pages.profile_photo") }}</label>
                                        <FormFileUpload :files="resource.avatar ? [resource.avatar] : []" type="employee_avatar"
                                                        @successDeleteUpload="successDeleteUpload" @successUpload="successUpload"/>
                                    </div>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button class="btn ripple btn-primary me-2" :disabled="disabled" @click.prevent="submit">{{ $t('forms.save') }}</button>
                                        <cancel-button/>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
