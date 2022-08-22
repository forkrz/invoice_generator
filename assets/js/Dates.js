import {Masks} from "./Masks";

const mask = new Masks();

export class Dates {

    loadMasks() {
        const today = new Date();
        document.getElementById('client_user_date_invoice_form_DATE_OF_ISSUE').value = this.getDateInMaskFormat();
        document.getElementById('client_user_date_invoice_form_PAY_BY').value = this.getDateInMaskFormat(7);
        document.getElementById('client_user_date_invoice_form_REALISED_ON').value = this.getDateInMaskFormat();

        mask.dateMask('client_user_date_invoice_form_DATE_OF_ISSUE').updateValue();
        mask.dateMask('client_user_date_invoice_form_PAY_BY').updateValue();
        mask.dateMask('client_user_date_invoice_form_REALISED_ON').updateValue();
    }

    getDateInMaskFormat(daysAhead = 0) {
        const today = new Date();
        const yyyy = today.getFullYear();
        let mm = today.getMonth() + 1; // Months start at 0!
        let dd = today.getDate() + daysAhead;

        if (dd < 10) dd = '0' + dd;
        if (mm < 10) mm = '0' + mm;

        return dd + '.' + mm + '.' + yyyy;
    }

}