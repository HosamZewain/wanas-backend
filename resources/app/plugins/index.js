import form from "./form"
import lodash from "./lodash"
import ability from "./ability"
import helpers from "./helpers"
import toast from "./toast"
import dayjs from "./dayjs"
import html2paper from "./VueHtmlToPaper"
import sweetAlert from './sweetAlert'
import ElementPlus from './elementPlus'

export default {
    install: (app, options) => {
        app.use(form);
        app.use(lodash);
        app.use(ability);
        app.use(helpers);
        app.use(toast);
        app.use(dayjs);
        app.use(sweetAlert);
        app.use(ElementPlus);
        app.use(html2paper);
    }
}
