<script>
    export default {
        props: {
            pagination: {
                type: [Object, Array],
                required: true
            },

            offset: {
                type: Number,
                default: 5
            }
        },

        data() {
            return {
                enteredPage: '',
            }
        },

        methods: {
            isCurrentPage(page) {
                return this.pagination.current_page === page;
            },

            changePage(page) {
                if (page > this.pagination.last_page) {
                    page = this.pagination.last_page;
                }
                //this.pagination.current_page = page;
                this.$emit('paginate', page);

                window.scrollTo(0, 0);
            },

            getPage() {
                if (_.isEmpty(this.enteredPage) || this.enteredPage <= 0 ||
                    this.enteredPage > this.pagination.last_page) {
                    return false;
                }

                this.changePage(this.enteredPage);
            },
        },

        computed: {
            pages() {
                let pages = [];
                let from = this.pagination.current_page - Math.floor(this.offset / 2);
                if (from < 1) {
                    from = 1;
                }
                let to = from + this.offset - 1;
                if (to > this.pagination.last_page) {
                    to = this.pagination.last_page;
                }
                while (from <= to) {
                    pages.push(from);
                    from++;
                }
                return pages;
            }
        }
    }

</script>

<template>
    <div class="pt-3" aria-label="Page navigation" v-if="pagination.last_page > 1">

        <!-- <div class="d-flex justify-content-center mb-3">
            <input class="bg-white form-control col-1 form-control-sm" type="number" v-model="enteredPage"
                @keyup="getPage" @change="getPage" placeholder="Goto Page" />
        </div> -->

        <ul class="pagination justify-content-center">

            <li class="page-item">
                <button class="page-link" aria-label="Previous" @click="changePage(1)">
                    {{$t('pagination.first_page')}}
                </button>
            </li>

            <li class="page-item">
                <button class="page-link" aria-label="Previous" :title="$t('pagination.prev')"
                    @click="changePage(pagination.current_page - 1)" :disabled="pagination.current_page <= 1">
                    <span aria-hidden="true">&laquo;</span>
                </button>
            </li>

            <li class="page-item" v-for="page in pages" :key="page" :class="{'active' : isCurrentPage(page)}">
                <button class="page-link" @click="changePage(page)">{{page}}</button>
            </li>

            <li class="page-item">
                <button class="page-link" aria-label="Next" :title="$t('pagination.next')"
                    @click="changePage(pagination.current_page + 1)"
                    :disabled="pagination.current_page >= pagination.last_page">
                    <span aria-hidden="true">&raquo;</span>
                </button>
            </li>

            <li class="page-item">
                <button class="page-link" aria-label="Next" @click="changePage(pagination.last_page)">
                    {{$t('pagination.last_page')}}
                </button>
            </li>

        </ul>

        <div class="text-center mt-2">
            <small>
                {{ $t('pagination.total') }} <strong>{{ pagination.total }}</strong>,
                {{ $t('pagination.showed') }} <strong>{{ pagination.from }}</strong> {{ $t('pagination.to') }} <strong>{{ pagination.to }}</strong>
            </small>
        </div>

    </div>
</template>

<style scoped>
    nav {
        background-color: transparent !important;
        box-shadow: none !important;
        color: #000 !important;
    }

    button:disabled {
        cursor: not-allowed;
    }

</style>
