export class Products {
    init() {
        document.forms[0].addEventListener('submit', (e) => {
            e.preventDefault();
            if (this.checkName() && this.checkPrice() && this.checkTaxRate()) {
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

    checkName() {
        const name = document.getElementById('NAME');
        const check = !this.checkIfEmpty(name)
        this.toggleErrorClass(name, check);
        return check;
    }

    checkPrice() {
        const name = document.getElementById('NET_PRICE');
        const check = !this.checkIfEmpty(name)
        this.toggleErrorClass(name, check);
        return check;
    }

    checkTaxRate() {
        const name = document.getElementById('TAX_RATE');
        const check = !this.checkIfEmpty(name)
        this.toggleErrorClass(name, check);
        return check;
    }
}