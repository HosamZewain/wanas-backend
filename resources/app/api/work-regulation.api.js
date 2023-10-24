import BaseApi from "./base.api";
import Http from "@services/http";

export default class WorkRegulationApi extends BaseApi {
    static get entity() {
        return "work-regulations";
    }
}
