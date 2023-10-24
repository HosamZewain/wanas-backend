import Http from "@services/http";

export default class FilterApi {

    static get entity()
    {
        return 'filters'
    }

    static async modelFilters(model, params = {})
    {
        return await Http.get(this.entity +'/' + model , params)
    }
}
