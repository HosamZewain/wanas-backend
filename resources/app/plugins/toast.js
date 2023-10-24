import Toast, {
    POSITION
} from "vue-toastification";
import "vue-toastification/dist/index.css";

export default {
    install: (app, options) => {

        const optionsDefaults = {
            timeout: 2000,
            position: POSITION.BOTTOM_LEFT,
            hideProgressBar: true,
            transition: "Vue-Toastification__fade",
            rtl: false
        };

        // Merge options argument into options defaults
        options = {
            ...optionsDefaults,
            ...options
        }

        app.use(Toast, options);
    }
}
