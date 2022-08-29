import {dateMasks} from "./Masks";
import dayjs from "dayjs";

export class Dates {
    setDefaultMasks() {
        const today = dayjs();
        document.getElementById('client_user_date_invoice_form_DATE_OF_ISSUE').value = today.format('DD.MM.YYYY');
        document.getElementById('client_user_date_invoice_form_PAY_BY').value = today.add(7, 'day').format('DD.MM.YYYY');
        document.getElementById('client_user_date_invoice_form_REALISED_ON').value = today.format('DD.MM.YYYY');
        dateMasks.creationDateMask.updateValue();
        dateMasks.paidToMask.updateValue();
        dateMasks.serviceDateMask.updateValue();
    }
}