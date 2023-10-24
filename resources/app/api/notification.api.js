import BaseApi from "@api/base.api";
import Http from "@services/http";
export default class NotificationApi extends BaseApi {
    static get entity() {
        return 'notifications'
    }

    static async toggleRead(model) {
        return await Http.put(`${this.entity}/${model.id}/toggle-read`)
    }

    static async takeAction(model, params) {
        return await Http.post(`${this.entity}/${model.id}/take-action`, params)
    }

    static async readAll(model) {
        return await Http.put(`${this.entity}/mark-all-as-read`)
    }

    static async unReadAll(model) {
        return await Http.put(`${this.entity}/mark-all-as-unread`)
    }

    static async deleteAll(model) {
        return await Http.delete(`${this.entity}/delete-all`)
    }

}
