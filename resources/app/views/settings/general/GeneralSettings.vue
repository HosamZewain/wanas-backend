<template>
    <div class="main-content side-content">
            <div class="container">
                <page-header title="sidebar.settings" :active="false">
                    <li class="breadcrumb-item active" aria-current="page">{{ $t('sidebar.general_settings') }}</li>
                </page-header>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card custom-card">
                            <div class="card-header rounded-bottom-0 my-3">
                                <div class="card-body">
                                    <form class="d-flex flex-column">
                                        <div class="row">
                                            <div class="col-lg-6 ">
                                                <form-input label="pages.on_hold_order_time" type="text"
                                                            :model="settings" name="on_hold_order_time" :errors="formErrors" @clearErrors="clearInput"/>
                                            </div>
                                            <div class="col-lg-6 ">
                                                <form-input label="pages.max_driver_orders_count" type="text"
                                                            :model="settings" name="max_driver_orders_count" :errors="formErrors" @clearErrors="clearInput"/>
                                            </div>

                                            <div class="col-lg-6 ">
                                                <form-input label="pages.driver_max_time_to_accept_order" type="number"
                                                            :model="settings" name="driver_max_time_to_accept_order" :errors="formErrors" @clearErrors="clearInput"/>
                                            </div>
                                            <div class="col-lg-6 ">
                                                <form-input label="pages.driver_max_time_to_pick_up_order" type="number"
                                                            :model="settings" name="driver_max_time_to_pick_up_order" :errors="formErrors" @clearErrors="clearInput"/>
                                            </div>
                                            <div class="col-lg-6 ">
                                                <form-input label="pages.driver_max_time_to_deliver_an_order" type="number"
                                                            :model="settings" name="driver_max_time_to_deliver_an_order" :errors="formErrors" @clearErrors="clearInput"/>
                                            </div>
                                            <div class="col-lg-6 ">
                                                <form-input label="pages.driver_max_time_to_move_after_accepting_order" type="number"
                                                            :model="settings" name="driver_max_time_to_move_after_accepting_order" :errors="formErrors" @clearErrors="clearInput"/>
                                            </div>
                                            <div class="col-lg-6 ">
                                                <form-input label="pages.driver_max_time_to_move_after_picking_up_order" type="number"
                                                            :model="settings" name="driver_max_time_to_move_after_picking_up_order" :errors="formErrors" @clearErrors="clearInput"/>
                                            </div>
                                            <div class="col-lg-6 ">
                                                <form-input label="pages.driver_max_time_to_spend_at_the_pickup_location" type="number"
                                                            :model="settings" name="driver_max_time_to_spend_at_the_pickup_location" :errors="formErrors" @clearErrors="clearInput"/>
                                            </div>
                                            <div class="col-lg-6 ">
                                                <form-input label="pages.driver_max_time_to_spend_in_the_delivery_location" type="number"
                                                            :model="settings" name="driver_max_time_to_spend_in_the_delivery_location" :errors="formErrors" @clearErrors="clearInput"/>
                                            </div>
                                            <div class="col-lg-6 ">
                                                <form-input label="pages.driver_max_time_order_to_be_assigned" type="number"
                                                            :model="settings" name="driver_max_time_order_to_be_assigned" :errors="formErrors" @clearErrors="clearInput"/>
                                            </div>
                                            <div class="col-lg-6 ">
                                                <form-switcher title="pages.auto_dispatching" label="pages.available" :model="settings"
                                                               name="auto_dispatching" :errors="formErrors" @clearErrors="clearInput"/>
                                            </div>
                                        </div>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button class="btn ripple btn-primary me-2" :disabled="submitFormDisabled" @click.prevent="submit">{{ $t('forms.save') }}</button>
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

<script>
import GeneralSettingsApi from "@api/general-settings.api";
import {useToast} from "vue-toastification";

export default {
    name: "GeneralSettings",
    data() {
        return {
            settings:{}
        }
    },
    methods: {
        getSettings()
        {
          GeneralSettingsApi.list()
              .then(({data})=>{
                  this.settings = data
              })
        },
        submit()
        {
            GeneralSettingsApi.update(this.settings)
                .then(({data}) => {
                    console.log(data)
                    useToast().success(this.$t('messages.success'))
                })
                .catch(error => {
                    console.log(error);
                    this.formErrors = error.response.data.errors;
                })
        }
    },
    created() {
        this.getSettings()
    }
}
</script>

<style scoped>

</style>
