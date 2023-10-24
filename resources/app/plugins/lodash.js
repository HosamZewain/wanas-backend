import lodash from "@/mixins/lodash"

export default {
    install: (app, options) => {
        app.mixin(lodash);
    }
}
