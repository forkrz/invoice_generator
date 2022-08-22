import {Masks} from "./Masks";

const mask = new Masks();

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
        const ClientsData = document.getElementById('clientsListData');
        const dataContainers = ClientsData.querySelectorAll('div');
        dataContainers.forEach(function (el, index) {
            el.querySelector('input').value = Object.values(clientData)[index];
        })
    }

    loadMasks() {
        mask.nipMask('client_user_date_invoice_form_USER_NIP');
        mask.zipCodeMask('client_user_date_invoice_form_USER_ZIP_CODE');
    }

}