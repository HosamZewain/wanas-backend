import BaseApi from "./base.api";

export default class RoleApi extends BaseApi {
    static get entity() {
        return 'roles'
    }
}
