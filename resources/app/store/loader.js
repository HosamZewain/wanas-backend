import {defineStore} from "pinia";

export const useLoaderStore = defineStore('loader', {
    state() {
        return {
            loading: false,
            requestsPending: 0,
        }
    },
    getters:{

    },
    actions: {
        add() {
            this.loading = true;
        },
        done() {
            this.loading = false;
        }
    }
})

