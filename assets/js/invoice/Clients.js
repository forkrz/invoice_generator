import IMask from "imask";
import {clientMasks} from "./UserAndDatesMasks";

export class Clients {

    showClientDataFromList() {
        const clientsList = document.getElementById("clientsListSelect");
        clientsList.addEventListener('change', () => {
            let selectedClient = clientsList.options[clientsList.selectedIndex];
            let clientData = {
                'nip': selectedClient.getAttribute('data-nip'),
                'company-name': selectedClient.getAttribute('data-company-name'),
                'street': selectedClient.getAttribute('data-Street'),
                'zip-code': selectedClient.getAttribute('data-zip-code'),
                'city': selectedClient.getAttribute('data-city'),
                'email': selectedClient.getAttribute('data-email'),
            }
            this.fillClientsData(clientData)
        })
    }

    fillClientsData(clientData) {
        let zipCodeMask = IMask(
            document.getElementById('client_user_date_invoice_form_CLIENT_ZIP_CODE'),
            {
                mask: '00-000'
            });

        let NipMask = IMask(
            document.getElementById('client_user_date_invoice_form_CLIENT_NIP'),
            {
                mask: '0000000000',
            });
        const ClientsData = document.getElementById('clientsListData');
        const dataContainers = ClientsData.querySelectorAll('div');
        dataContainers.forEach(function (el, index) {
            el.querySelector('input').value = Object.values(clientData)[index];
        })
        zipCodeMask.updateValue();
        NipMask.updateValue();
    }
}