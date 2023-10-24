<template>
    <div class="main-content side-content">
        <div class="container">
            <page-header title="sidebar.settings" :active="false">
                <li class="breadcrumb-item active" aria-current="page">{{ $t('sidebar.logs') }}</li>
            </page-header>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card custom-card">
                        <div class="card-header rounded-bottom-0 my-3">
                            <div class="card-body">
                                <filters @submit="getLogs" :model="filters" :enableKeyword="false">
                                    <div class="col-sm-6 col-md-6">
                                        <div class="mb-3">
                                            <el-date-picker
                                                v-model="filters.duration"
                                                type="daterange"
                                                unlink-panels
                                                range-separator="|"
                                                format="YYYY/MM/DD"
                                                value-format="YYYY-MM-DD"
                                                :start-placeholder="$t('pages.date_from')"
                                                :end-placeholder="$t('pages.date_to')"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-4">
                                        <div class="mb-3">
                                            <el-select v-model="filters.user" :clearable="true"
                                                       :filterable="true" :placeholder="$t('forms.select') +' '+ $t('pages.user')">
                                                <el-option
                                                    v-for="item in users"
                                                    :key="item.id"
                                                    :label="item.name"
                                                    :value="item.id"
                                                />
                                            </el-select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-4">
                                        <div class="mb-3">
                                            <el-select v-model="filters.module" :clearable="true"
                                                       :filterable="true" :placeholder="$t('forms.select') +' '+ $t('pages.module')">
                                                <el-option
                                                    v-for="item in modules"
                                                    :key="item"
                                                    :label="item"
                                                    :value="item"
                                                />
                                            </el-select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-4">
                                        <div class="mb-3">
                                            <el-select v-model="filters.action" :clearable="true"
                                                       :filterable="true" :placeholder="$t('forms.select') +' '+ $t('pages.action')">
                                                <el-option
                                                    v-for="item in actions"
                                                    :key="item"
                                                    :label="item"
                                                    :value="item"
                                                />
                                            </el-select>
                                        </div>
                                    </div>
                                </filters>
                                <div class="table-responsive" v-if="logs.length">
                                    <table class="table table-bordered border text-nowrap mb-0" id="new-edit">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ $t('pages.action') }}</th>
                                            <th>{{ $t('pages.module') }}</th>
                                            <th>{{ $t('pages.message') }}</th>
                                            <th>{{ $t('pages.by') }}</th>
                                            <th>{{ $t('pages.date') }}</th>
                                            <th>{{ $t('pages.time') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(log, index) in logs" :key="log.id">
                                            <td>{{ index + pagination.from }}</td>
                                            <td>{{ log.action }}</td>
                                            <td>{{ log.module }}</td>
                                            <td>{{ log.message }}</td>
                                            <td>{{ log.by }}</td>
                                            <td>{{ log.date }}</td>
                                            <td>{{ log.time }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <strong v-if="!logs.length && !this.$store.loaderStore.loading" class="text-danger">{{
                                        $t('global.no_results')
                                    }}</strong>
                                <spinner/>
                                <pagination :pagination="pagination" @paginate="getLogs"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LogApi from "@api/logs.api";
import FilterApi from "@api/filter.api";

export default {
    name: "LogIndex",
    data(){
        return {
            logs:[],
            modules:[],
            actions:[],
            users:[],
            filters:{
                page:1
            },
            pagination: {},
        }
    },
    methods: {
        getLogs(page = 1)
        {
            this.filters.page = page
            LogApi.list(this.filters)
                .then(({data})=>{
                    this.logs = data.data
                    this.pagination = data.meta
                })
        },
        getFilters()
        {
            LogApi.getModulesActions()
                .then(({data})=>{
                    this.modules = data.modules
                    this.actions = data.actions
                })
            FilterApi.modelFilters('ActivityLog')
                .then(({data})=>{
                    this.users = data.users
                })
        }
    },
    created() {
        this.getLogs()
        this.getFilters()
    }
}
</script>

<style scoped>

</style>
