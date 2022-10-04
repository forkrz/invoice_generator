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

    toggleError(el,message, isOk) {
        !isOk ? el.classList.add('error') : el.classList.remove('error');
        !isOk ? message.style.visibility = 'visible' : message.style.visibility = 'hidden';
    }

    checkName() {
        const name = document.getElementById('NAME');
        const errorMsg = document.getElementById('name-error');
        const check = !this.checkIfEmpty(name);
        this.toggleError(name, errorMsg, check);
        return check;
    }

    checkPrice() {
        const name = document.getElementById('NET_PRICE');
        const errorMsg = document.getElementById('price-error');
        const check = !this.checkIfEmpty(name);
        this.toggleError(name, errorMsg, check);
        return check;
    }

    checkTaxRate() {
        const name = document.getElementById('TAX_RATE');
        const errorMsg = document.getElementById('tax-error');
        const check = !this.checkIfEmpty(name);
        this.toggleError(name,errorMsg, check);
        return check;
    }
}