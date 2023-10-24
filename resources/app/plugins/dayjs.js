import dayjs from 'dayjs'

export default {
    install: (app, options) => {
        app.config.globalProperties.$dayjs = dayjs
    }
}