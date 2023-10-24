import BaseApi from "./base.api";

export default class PermissionApi extends BaseApi {
    static get entity() {
        return 'permissions'
    }
}
