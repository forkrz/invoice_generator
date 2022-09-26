export class Settings {
    init() {
        document.forms[0].addEventListener('submit', (e) => {
            e.preventDefault();
            if (this.checkNip() && this.checkName() && this.checkStreet() && this.checkZipCode() && this.checkCity() && this.checkEmail()) {
                e.currentTarget.submit();
            }
        });
    }

    checkIfEmpty(el) {
        return !el.value.trim().length;
    }

    toggleErrorInfo(element,message, isOk) {
        !isOk ? element.classList.add('error') : element.classList.remove('error');
        !isOk ? message.style.display = 'block' : message.style.display = 'none';
    }


    checkNip() {
        const nip = document.getElementById('NIP');
        const errorMsg = document.getElementById('nip-error');
        if (!this.checkIfEmpty(nip)) {
            const tenNumbersRegex = /^[0-9]{10}$/;
            const regex = new RegExp(tenNumbersRegex);
            const NipCheck = regex.test(nip.value);
            this.toggleErrorInfo(nip,errorMsg, NipCheck);
            return NipCheck;
        } else {
            this.toggleErrorInfo(nip,errorMsg, false);
        }
    }

    checkZipCode() {
        const zipCode = document.getElementById('ZIP');
        const errorMsg = document.getElementById('zip-code-error');
        if (!this.checkIfEmpty(zipCode)) {
            const zipCodeRegex = /\d{2}-\d{3}/;
            const regex = new RegExp(zipCodeRegex);
            const zipCodeCheck = regex.test(zipCode.value);
            this.toggleErrorInfo(zipCode,errorMsg, zipCodeCheck);
            return zipCodeCheck;
        } else {
            this.toggleErrorInfo(zipCode,errorMsg, false);
        }
    }

    checkName() {
        const name = document.getElementById('NAME');
        const errorMsg = document.getElementById('name-error');
        const check = !this.checkIfEmpty(name)
        this.toggleErrorInfo(name,errorMsg, check);
        return check;
    }

    checkStreet() {
        const name = document.getElementById('STREET');
        const errorMsg = document.getElementById('street-error');
        const check = !this.checkIfEmpty(name)
        this.toggleErrorInfo(name,errorMsg, check);
        return check;
    }

    checkCity() {
        const name = document.getElementById('CITY');
        const errorMsg = document.getElementById('city-error');
        const check = !this.checkIfEmpty(name)
        this.toggleErrorInfo(name,errorMsg, check);
        return check;
    }

    checkEmail() {
        const name = document.getElementById('EMAIL');
        const errorMsg = document.getElementById('email-error');
        const check = !this.checkIfEmpty(name)
        this.toggleErrorInfo(name,errorMsg, check);
        return check;
    }
}