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

    toggleErrorClass(el, isOk) {
        !isOk ? el.classList.add('error') : el.classList.remove('error');
    }

    checkNip() {
        const nip = document.getElementById('NIP');
        if (!this.checkIfEmpty(nip)) {
            const tenNumbersRegex = /^[0-9]{10}$/;
            const regex = new RegExp(tenNumbersRegex);
            const NipCheck = regex.test(nip.value);
            this.toggleErrorClass(nip, NipCheck);
            return NipCheck;
        } else {
            this.toggleErrorClass(nip, false);
            return false;
        }
    }

    checkZipCode() {
        const zipCode = document.getElementById('ZIP');
        if (!this.checkIfEmpty(zipCode)) {
            const zipCodeRegex = /\d{2}-\d{3}/;
            const regex = new RegExp(zipCodeRegex);
            const zipCodeCheck = regex.test(zipCode.value);
            this.toggleErrorClass(zipCode, zipCodeCheck);
            return zipCodeCheck;
        } else {
            this.toggleErrorClass(zipCode, false);
            return false;
        }
    }

    checkName() {
        const name = document.getElementById('NAME');
        const check = !this.checkIfEmpty(name)
        this.toggleErrorClass(name, check);
        return check;
    }

    checkStreet() {
        const name = document.getElementById('STREET');
        const check = !this.checkIfEmpty(name)
        this.toggleErrorClass(name, check);
        return check;
    }

    checkCity() {
        const name = document.getElementById('CITY');
        const check = !this.checkIfEmpty(name)
        this.toggleErrorClass(name, check);
        return check;
    }

    checkEmail() {
        const name = document.getElementById('EMAIL');
        const check = !this.checkIfEmpty(name)
        this.toggleErrorClass(name, check);
        return check;
    }
}