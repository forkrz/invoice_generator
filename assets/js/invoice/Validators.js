export class Validators {
    init() {
        document.forms[0].addEventListener('submit', (e) => {
            e.preventDefault();
            if(this.checkUserAndClientsData() && this.productsCheck()){
                e.currentTarget.submit();
            }
        });
    }

    checkUserAndClientsData() {
        return this.checkNips() && this.checkNames() && this.checkStreets() && this.checkZipCodes() && this.checkCities() && this.checkEmails();
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
                document.getElementById('user-nip-error').style.visibility = 'hidden';
                document.getElementById('client-nip-error').style.visibility = 'hidden';
                return true;
            } else {
                userNip.classList.add('error');
                clientNip.classList.add('error');
                document.getElementById('user-nip-error').style.visibility = 'visible';
                document.getElementById('client-nip-error').style.visibility = 'visible';
                document.getElementById('user-nip-error').textContent = 'Nips cannot be the same';
                document.getElementById('client-nip-error').textContent = 'Nips cannot be the same';
            }
        } else {
            if(userNipCheck) {
                userNip.classList.remove('error');
                document.getElementById('user-nip-error').style.visibility = 'hidden';
            } else{
                userNip.classList.add('error');
                document.getElementById('user-nip-error').innerText('Nip must have exactly 10 numbers');
                document.getElementById('user-nip-error').style.visibility = 'visible';
            }
            if(clientNipCheck) {
                clientNip.classList.remove('error');
                document.getElementById('client-nip-error').style.visibility = 'hidden';
            } else {
                clientNip.classList.add('error');
                document.getElementById('client-nip-error').innerText('Nip must have exactly 10 numbers');
                document.getElementById('client-nip-error').style.visibility = 'visible';
            }
        }
    }

    checkZipCodes() {
        const zipCodeRegex = /\d{2}-\d{3}/;
        const regex = new RegExp(zipCodeRegex);
        const userZipCode = document.getElementById('client_user_date_invoice_form_USER_ZIP_CODE');
        const clientZipCode = document.getElementById('client_user_date_invoice_form_CLIENT_ZIP_CODE');
        const userZipCodeCheck = regex.test(userZipCode.value);
        const clientZipCodeCheck = regex.test(clientZipCode.value);
        if (userZipCodeCheck) {
            userZipCode.classList.remove('error')
            document.getElementById('user-zip-code-error').style.visibility = 'hidden';
        } else {
            userZipCode.classList.add('error');
            document.getElementById('user-zip-code-error').style.visibility = 'visible';
        }

        if (clientZipCodeCheck) {
            clientZipCode.classList.remove('error')
            document.getElementById('client-zip-code-error').style.visibility = 'hidden';
        } else {
            clientZipCode.classList.add('error');
            document.getElementById('client-zip-code-error').style.visibility = 'visible';
        }

        return (userZipCodeCheck && clientZipCodeCheck);
    }

    checkNames() {
        const userName = document.getElementById('client_user_date_invoice_form_USER_NAME');
        const clientName = document.getElementById('client_user_date_invoice_form_CLIENT_NAME');
        const userNameCheck = userName.value !== '';
        const clientNameCheck = clientName.value !== '';

        if (userNameCheck) {
            userName.classList.remove('error')
            document.getElementById('user-name-error').style.visibility = 'hidden';
        } else {
            userName.classList.add('error');
            document.getElementById('user-name-error').style.visibility = 'visible';
        }

        if (clientNameCheck) {
            clientName.classList.remove('error')
            document.getElementById('client-name-error').style.visibility = 'hidden';
        } else {
            clientName.classList.add('error');
            document.getElementById('client-name-error').style.visibility = 'visible';
        }

        return (userNameCheck && clientNameCheck);
    }

    checkStreets() {
        const userStreet = document.getElementById('client_user_date_invoice_form_USER_STREET');
        const clientStreet = document.getElementById('client_user_date_invoice_form_CLIENT_STREET');
        const userStreetCheck = userStreet.value !== '';
        const clientStreetCheck = clientStreet.value !== '';

        if (userStreetCheck) {
            userStreet.classList.remove('error')
            document.getElementById('user-street-error').style.visibility = 'hidden';
        } else {
            userStreet.classList.add('error');
            document.getElementById('user-street-error').style.visibility = 'visible';
        }

        if (clientStreetCheck) {
            clientStreet.classList.remove('error')
            document.getElementById('client-street-error').style.visibility = 'hidden';
        } else {
            clientStreet.classList.add('error');
            document.getElementById('client-street-error').style.visibility = 'visible';
        }

        return (userStreetCheck && clientStreetCheck);
    }

    checkCities() {
        const userCity = document.getElementById('client_user_date_invoice_form_USER_CITY');
        const clientCity = document.getElementById('client_user_date_invoice_form_CLIENT_CITY');
        const userCityCheck = userCity.value !== '';
        const clientCityCheck = clientCity.value !== '';

        if (userCityCheck) {
            userCity.classList.remove('error')
            document.getElementById('user-city-error').style.visibility = 'hidden';
        } else {
            userCity.classList.add('error');
            document.getElementById('user-city-error').style.visibility = 'visible';
        }

        if (clientCityCheck) {
            clientCity.classList.remove('error')
            document.getElementById('client-city-error').style.visibility = 'hidden';
        } else {
            clientCity.classList.add('error');
            document.getElementById('client-city-error').style.visibility = 'visible';
        }

        return (userCityCheck && clientCityCheck);
    }

    checkEmails() {
        const emailRegex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        const regex = new RegExp(emailRegex);
        const userEmail = document.getElementById('client_user_date_invoice_form_USER_EMAIL');
        const clientEmail = document.getElementById('client_user_date_invoice_form_CLIENT_EMAIL');
        const userEmailCheck = regex.test(userEmail.value);
        const clientEmailCheck = regex.test(clientEmail.value);

        if (userEmailCheck) {
            userEmail.classList.remove('error')
            document.getElementById('user-email-error').style.visibility = 'hidden';
        } else {
            userEmail.classList.add('error');
            document.getElementById('user-email-error').style.visibility = 'visible';
        }

        if (clientEmailCheck) {
            clientEmail.classList.remove('error')
            document.getElementById('client-email-error').style.visibility = 'hidden';
        } else {
            clientEmail.classList.add('error');
            document.getElementById('client-email-error').style.visibility = 'visible';
        }

        return (userEmailCheck && clientEmailCheck);
    }

    productsCheck() {
        let productList = document.querySelectorAll('.product-container');
        const checks = []
        productList.forEach(el=>{
            checks.push(this.checkProductData(el))
        });
        return !checks.includes(false);
    }

    checkProductData(el) {
        const index = el.dataset.index;
        const inputs = el.querySelectorAll('input');
        return this.checkProductName(inputs[0], index) && this.checkIfInputGreaterThanZero(inputs[1], index, 'product-quantity-error-') && this.checkIfInputGreaterThanZero(inputs[2], index, 'product-price-error-') && this.checkIfInputGreaterThanZero(inputs[3], index, 'product-tax-error-');
    }

    checkProductName(el, index) {
        const nameCheck = el.value !== '';
        if (nameCheck) {
            el.classList.remove('error');
            document.getElementById('product-name-error-' + index).style.visibility = 'hidden';
        } else {
            el.classList.add('error');
            document.getElementById('product-name-error-' + index).style.visibility = 'visible';
        }
        return nameCheck;
    }

    checkIfInputGreaterThanZero(el, index, errorIdName) {
        if (el.value !== '' || el.value > 0) {
            el.classList.remove('error')
            document.getElementById(errorIdName + index).style.visibility = 'hidden';
            return true;
        } else {
            el.classList.add('error');
            document.getElementById(errorIdName + index).style.visibility = 'visible';
            return false;
        }
    }

}