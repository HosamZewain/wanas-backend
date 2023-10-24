import ExportExcelApi from "@api/export-excel.api";

export default {

    methods: {
        download(data)
        {
            const docUrl = document.createElement('a');
            docUrl.href = this.publicUrl + data.url;
            docUrl.setAttribute('download', 'report.xlsx');
            document.body.appendChild(docUrl);
            docUrl.click();
        }
    }
}
