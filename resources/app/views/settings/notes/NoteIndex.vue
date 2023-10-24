<template>
    <div class="main-content side-content">
        <div class="container">
            <page-header title="sidebar.settings" :active="false">
                <li class="breadcrumb-item active" aria-current="page">{{ $t('sidebar.notes') }}</li>
            </page-header>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card custom-card">
                        <div class="card-header rounded-bottom-0 my-3">
                            <div class="card-body">
                                <button class="btn btn-sm btn-primary m-1" v-if="hasPermission('create', 'Note')" @click="noteForm">
                                    <span class="fas fa-plus"></span> {{$t('pages.add_new_note')}}
                                </button>
                                <filters @submit="getNotes" :model="filters">
                                </filters>
                                <div class="table-responsive"  v-if="notes.length">
                                    <table class="table table-bordered border text-nowrap mb-0" id="new-edit">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ $t('pages.note') }}</th>
                                            <th>{{ $t('global.actions') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(note, index) in notes" :key="note.id">
                                            <td>{{ index + pagination.from }}</td>
                                            <td>{{ note.content }}</td>
                                            <td name="bstable-actions">
                                                <div class="btn-list">
                                                    <button class="btn btn-sm btn-primary m-1" v-if="hasPermission('update', 'Note')" @click="noteForm(note)">
                                                        <span class="fas fa-edit"></span>
                                                    </button>
                                                    <delete-button v-if="hasPermission('delete', 'Note')" @del-model="delNote(note, index)"/>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <strong v-if="!notes.length && !loaderStore.loading" class="text-danger">{{
                                        $t('global.no_results')
                                    }}</strong>
                                <spinner/>
                                <pagination :pagination="pagination" @paginate="getNotes"/>
                                <note-form :title="title" :showButton="false"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import NoteForm from "@views/settings/notes/NoteForm.vue";
import {useToast} from "vue-toastification";
import NoteApi from "@api/note.api";
export default {
    name: "NoteIndex",
    components: {NoteForm},
    data() {
        return {
            notes: [],
            filters: {
                page: 1,
                visible: 1
            },
            pagination: {},
            note:{},
            title:'pages.add_new_note'
        }
    },
    created() {
        this.getNotes();
    },
    methods: {
        getNotes(page = 1) {
            this.filters.page = page;
            NoteApi.list(this.filters)
                .then(({data}) => {
                    this.notes = data.data;
                    this.pagination = data.meta;
                }).catch(error => {
                    console.log(error);
                }
            );
        },
        delNote(type, index) {
            NoteApi.delete(type)
                .then(resp => {
                    this.notes.splice(index, 1);
                    useToast().success(resp.data.message);
                });
        },
        noteForm(note = {}){
            if (note.id){
                this.title = 'pages.edit_note'
                this.note = _.cloneDeep(note)
            }else{
                this.title = 'pages.add_new_note'
            }
            $('#noteForm').modal('show');
        }
    }
}
</script>

<style scoped>

</style>
