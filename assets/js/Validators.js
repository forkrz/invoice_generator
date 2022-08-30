export class Validators {
    init() {
        document.forms[0].addEventListener('submit', (e) => {
            e.preventDefault();
            this.checkNips();
        });
    }

    checkNips() {
        const tenNumbersRegex = /^[0-9]{10}$/;
        const regex = new RegExp(tenNumbersRegex);
        const userNip = document.getElementById('client_user_date_invoice_form_USER_NIP');
        const clientNip = document.getElementById('client_user_date_invoice_form_CLIENT_NIP');
        const userNipCheck = regex.test(userNip.value);
        const clientNipCheck = regex.test(clientNip.value);

        if (userNipCheck && clientNipCheck) {
            if (userNip.value !== clientNip.value) {
                return true;
            } else {
                userNip.classList.add('error');
                clientNip.classList.add('error');
            }
        }

        userNipCheck ? userNip.classList.remove('error') : userNip.classList.add('error');
        clientNipCheck ? clientNip.classList.remove('error') : clientNip.classList.add('error');
    }
}