import Http from "@services/http";

export default class ExportExcelApi {

    static get entity() {
        return 'export-excel'
    }
    static get reportEntity() {
        return 'reports'
    }

    static async deliverTimeReport(params) {
        return await Http.get(this.entity + '/'+ this.reportEntity +'/delivery-time', params)
    }

    static async driverOrderCountReport(params) {
        return await Http.get(this.entity + '/'+ this.reportEntity +'/driver-order-count', params)
    }

    static async OrdersDeliveryDurationReport(params) {
        return await Http.get(this.entity + '/'+ this.reportEntity +'/orders-delivery-duration', params)
    }

    static async salesOrdersReport(params) {
        return await Http.get(this.entity + '/'+ this.reportEntity +'/sales-orders', params)
    }

    static async customerOrdersReport(params) {
        return await Http.get(this.entity + '/'+ this.reportEntity +'/customer-orders', params)
    }

    static async driversReport(params) {
        return await Http.get(this.entity + '/'+ this.reportEntity +'/drivers', params)
    }
}
