import BaseApi from "./base.api";
import Http from "@services/http";

export default class FileApi extends BaseApi {
    static get entity() {
        return 'files'
    }
    static async store(model,config) {
        return await Http.post(`${this.entity}`, model,config)
    }
}
