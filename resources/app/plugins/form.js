import form from "@/mixins/form"

export default {
    install: (app, options) => {
        app.mixin(form);
    }
}
