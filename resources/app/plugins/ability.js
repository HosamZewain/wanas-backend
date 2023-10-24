import ability from "@/mixins/ability"

export default {
    install: (app, options) => {
        app.mixin(ability);
    }
}
