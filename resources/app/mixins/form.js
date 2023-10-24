export default class FormHelper {

    static formErrors = [];
    static submitFormDisabled = false;

    static async clearInput(fieldName) {
        delete this.formErrors[fieldName];
        this.submitFormDisabled = Object.keys(this.formErrors).length > 0;
    }

    static async inputValidation(name) {
        return this.formErrors[name] ?? '';
    }

    static async prepareValidations(errors) {
        let formErrors = [];
        Object.keys(errors).forEach(function (key) {
            formErrors[key] = errors[key];
        });
        this.formErrors = formErrors;
    }

    static async clearErrors() {
        this.formErrors = [];
        this.submitFormDisabled = false;
    }

    static async resetForm(data, exceptKeys = []) {
        await this.clearErrors()
        Object.keys(data).forEach(function (key) {
            // data[key] = '';
            if (!exceptKeys.includes(key)) {
                let className = data[key]?.constructor?.name
                switch (className) {
                    case 'Array':
                        data[key] = []
                        break;
                    case 'Object':
                        data[key] = {}
                        break;
                    default:
                        data[key] = ''
                        break;
                }
            }
        });
    }

    static async fillForm(data, model) {
        Object.keys(data).forEach(function (key) {
            data[key] = model[key];
        });
    }

    //do After add (for bootstrap modal)
    static async afterModalAddActions(form, grid, data) {
        await this.resetForm(form);
        await this.addToGrid(grid, data)
    }

    static async addToGrid(grid, data) {
        let length = grid.length
        if (length >= 10) {
            grid.splice(9, 1);
        }
        grid.unshift(data)
    }

    //do After add (for bootstrap modal)
    static async afterModalUpdateActions(form, grid, data, id) {
        await this.updateGrid(grid, data, id)
        await this.resetForm(form);
    }

    static async updateGrid(grid, data, id) {
        let objIndex = grid.findIndex((obj => obj.id === id));
        grid[objIndex] = data;
    }

    static async confirmBox(message = '', confirmBtn = '') {
        return this.$swal.fire({
            customClass: {
                confirmButton: 'btn btn-success m-2',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false,
            title: 'Are you sure?',
            text: message + " !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: confirmBtn + '!',
            cancelButtonText: 'No!',
            reverseButtons: true
        })
    }

    static parseHtmlToText(html = '') {
        html = html.replace(/&lt;/g , "<");
        html = html.replace(/&gt;/g , ">");
        html = html.replace(/&quot;/g , "\"");
        html = html.replace(/&#39;/g , "\'");
        html = html.replace(/&amp;/g , "&");
        return html;
    }

}
