export class Validators {
    init() {
        document.forms[0].addEventListener('submit', (e) => {
            e.preventDefault();
            this.checkNips();
            this.checkZipCodes();
        });
        this.productsCheck();
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
                userNip.classList.remove('error');
                clientNip.classList.remove('error');
                return true;
            } else {
                userNip.classList.add('error');
                clientNip.classList.add('error');
            }
        } else {
            userNipCheck ? userNip.classList.remove('error') : userNip.classList.add('error');
            clientNipCheck ? clientNip.classList.remove('error') : clientNip.classList.add('error');
        }
    }

    checkZipCodes() {
        const zipCodeRegex = /\d{2}-\d{3}/;
        const regex = new RegExp(zipCodeRegex);
        const userZipCode = document.getElementById('client_user_date_invoice_form_USER_ZIP_CODE');
        const clientZipCode = document.getElementById('client_user_date_invoice_form_CLIENT_ZIP_CODE');
        const userZipCodeCheck = regex.test(userZipCode.value);
        const clientZipCodeCheck = regex.test(clientZipCode.value);

        userZipCodeCheck ? userZipCode.classList.remove('error') : userZipCode.classList.add('error');
        clientZipCodeCheck ? clientZipCode.classList.remove('error') : clientZipCode.classList.add('error');

    }

    productsCheck() {
        let productList = document.querySelectorAll('.product-container');
        productList.forEach(el => this.checkProductData(el))
    }
    checkProductData(el){
        el.childNodes.forEach(el => {
            el.childNodes.forEach(el => {
                if(el.tagName === 'INPUT'){

                };
            });
        })
    }
}