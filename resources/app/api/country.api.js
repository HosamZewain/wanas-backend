import BaseApi from "./base.api";

export default class CountryApi extends BaseApi {
    static get entity() {
        return 'countries'
    }
}
