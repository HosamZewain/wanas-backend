import {defineStore} from "pinia";

export const useTimerStore = defineStore('timer', {
    state() {
        return {
            timer: false,
        }
    },
    getters:{

    },
    actions: {
        toggle() {
            this.timer = !this.timer;
        }
    }
})

