import excel from "@/mixins/helpers"

export default {
    install: (app, options) => {
        app.mixin(excel);
    }
}
