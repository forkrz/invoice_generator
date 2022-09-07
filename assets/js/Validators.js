export class Validators {
    init() {
        document.forms[0].addEventListener('submit', (e) => {
            e.preventDefault();
            if(this.checkNips() && this.checkZipCodes() && this.productsCheck()){
                e.currentTarget.submit();
            }
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
        return (userZipCodeCheck && clientZipCodeCheck);
    }

    productsCheck() {
        let productList = document.querySelectorAll('.product-container');
        const checks = []
        productList.forEach(el => checks.push(this.checkProductData(el)));
        return !checks.includes(false);
    }

    checkProductData(el) {
        const productData = el.getElementsByTagName('INPUT');
        const checks = [
            this.checkProductName(productData[0]),
            //quantity
            this.checkIfInputGreaterThanZero(productData[1]),
            //net price
            this.checkIfInputGreaterThanZero(productData[2]),
            //tax rate
            this.checkIfInputGreaterThanZero(productData[3]),
            //net value
            this.checkIfInputGreaterThanZero(productData[4]),
        ]
        return !checks.includes(false);

    }

    checkProductName(el) {
        if (el.value !== '') {
            el.classList.remove('error');
            return true;
        } else {
            el.classList.add('error');
            return false;
        }
    }

    checkIfInputGreaterThanZero(el) {
        if (el.value !== '' || el.value > 0) {
            el.classList.remove('error');
            return true;
        } else {
            el.classList.add('error');
            return false;
        }
    }

}