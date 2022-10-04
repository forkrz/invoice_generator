import IMask from "imask";

export class Products {

    init() {
        const productContainer = document.querySelectorAll('.product-container')[document.querySelectorAll('.product-container').length - 1];
        let inputLists = productContainer.querySelectorAll('.product-container > div');
        let quantityMask = IMask(
            inputLists[1].querySelector('input'),
            {
                mask: Number,
                min: 1,
                max: 99,
                scale: 0,
                signed: false
            });

        let netPriceMask = IMask(
            inputLists[2].querySelector('input'),
            {
                mask: Number,
                min: 1,
                max: 9999,
                scale: 2,
                signed: false,
                radix: '.'
            });

        let taxRateMask = IMask(
            inputLists[3].querySelector('input'),
            {
                mask: Number,
                min: 1,
                max: 99,
                scale: 0,
                signed: false
            });

        this.addNewProductInput();
        if(typeof document.querySelectorAll('.product-container')[document.querySelectorAll('.product-select').length - 1] !== 'undefined'){
            this.fillProductData(document.querySelectorAll('.product-select')[document.querySelectorAll('.product-select').length - 1], netPriceMask, taxRateMask);
        }
        this.calculateNetValue(document.getElementById('client_user_date_invoice_form_Product___name___Quantity'), document.getElementById('client_user_date_invoice_form_Product___name___NET_PRICE'), document.getElementById('client_user_date_invoice_form_Product___name___NET_VALUE'));
        this.calculateTaxValue(document.getElementById('client_user_date_invoice_form_Product___name___Quantity'), document.getElementById('client_user_date_invoice_form_Product___name___NET_PRICE'), document.getElementById('client_user_date_invoice_form_Product___name___TAX_RATE'), document.getElementById('client_user_date_invoice_form_Product___name___TAX_VALUE'));
        this.calculateGrossValue(document.getElementById('client_user_date_invoice_form_Product___name___Quantity'), document.getElementById('client_user_date_invoice_form_Product___name___NET_PRICE'), document.getElementById('client_user_date_invoice_form_Product___name___TAX_RATE'), document.getElementById('client_user_date_invoice_form_Product___name___NET_VALUE'), document.getElementById('client_user_date_invoice_form_Product___name___TAX_VALUE'), document.getElementById('client_user_date_invoice_form_Product___name___GROSS_VALUE'));
        this.deleteProduct(document.getElementsByClassName("fa-solid fa-xmark delete-product-icon")[0]);
    }

    addNewProductInput() {
        const productsList = document.getElementById('products-list');
        const inputDiv = productsList.getElementsByTagName('div')[2];
        const addProductButton = document.getElementById('add-product-button');
        addProductButton.addEventListener('click', (e) => {
            e.preventDefault();
            const lastDiv = Array.from(productsList.querySelectorAll('.product-container')).pop();
            let NewProductInput = inputDiv.cloneNode(true);
            const currentIndex = parseInt(lastDiv.dataset.index);
            NewProductInput.dataset.index = currentIndex + 1;

            NewProductInput.querySelectorAll('div').forEach((el) => {
                el.id = el.id.replace('__name__', currentIndex + 1);
                el.querySelectorAll('input').forEach((elChild) => {
                    elChild.id = elChild.id.replace('__name__', currentIndex + 1);
                    elChild.name = elChild.name.replace('__name__', currentIndex + 1);
                    elChild.value = '';
                })
                const errorProductMsg = el.querySelectorAll('.invoice-generate-error-msg');
                errorProductMsg.forEach((elem) => {
                    let id = elem.id.split('-');
                    elem.id = ''
                    for (let i = 0; i < id.length -1; i++) {
                        elem.id += id[i];
                        elem.id += '-'
                    }
                    elem.id += parseInt(currentIndex + 1);
                })
            });

            productsList.append(NewProductInput);
            let inputLists = NewProductInput.querySelectorAll('div > input');
            let quantityMask = IMask(
                inputLists[1],
                {
                    mask: Number,
                    min: 1,
                    max: 99,
                    scale: 0,
                    signed: false
                });

            let netPriceMask = IMask(
                inputLists[2],
                {
                    mask: Number,
                    min: 1,
                    max: 9999,
                    scale: 2,
                    signed: false,
                    radix: '.'
                });

            let taxRateMask = IMask(
                inputLists[3],
                {
                    mask: Number,
                    min: 1,
                    max: 99,
                    scale: 0,
                    signed: false
                });

            if(typeof document.querySelectorAll('.product-container')[document.querySelectorAll('.product-select').length - 1] !== 'undefined') {
                this.fillProductData(document.querySelectorAll('.product-select')[document.querySelectorAll('.product-select').length - 1], netPriceMask, taxRateMask)
            }
            this.calculateNetValue(inputLists[1], inputLists[2], inputLists[4]);
            this.calculateTaxValue(inputLists[1], inputLists[2], inputLists[3], inputLists[5]);
            this.calculateGrossValue(inputLists[1], inputLists[2], inputLists[3], inputLists[4], inputLists[5], inputLists[6]);
            this.deleteProduct(NewProductInput.querySelector('i'));
            this.toggleDeleteButtons();
        })
    }

    fillProductData(el, netPriceMask, taxRateMask) {
        el.addEventListener('change', (e) => {
            e.preventDefault();
            let selectedProduct = el.options[el.selectedIndex];
            let productData = {
                'name': selectedProduct.getAttribute('data-name'),
                'price': selectedProduct.getAttribute('data-price'),
                'tax': selectedProduct.getAttribute('data-tax-rate'),
            }
            const productContainer = el.parentNode.parentNode;
            const inputLists = productContainer.querySelectorAll('input');
            inputLists[0].value = productData.name;
            inputLists[2].value = productData.price;
            inputLists[3].value = productData.tax;

            netPriceMask.updateValue();
            taxRateMask.updateValue();
            inputLists[2].dispatchEvent(new Event('change'));
            inputLists[3].dispatchEvent(new Event('change'));
        })
    }

    calculateNetValue(quantity, netPrice, netValue) {
        let calculate = () => {
            let quantityVal = quantity.value;
            let netPriceVal = netPrice.value;
            if (quantityVal && netPriceVal) {
                quantityVal = parseInt(quantityVal);
                netPriceVal = parseFloat(netPriceVal);
                if (quantityVal !== 0 && netPriceVal !== 0) {
                    netValue.value = (quantityVal * netPriceVal).toFixed(2);
                } else {
                    netValue.value = '';
                }
            }
        }
        quantity.addEventListener('change', () => {
            calculate();
        })
        netPrice.addEventListener('change', () => {
            calculate();
        })
    }

    calculateTaxValue(quantity, netPrice, taxRate, taxValue) {
        let calculate = () => {
            let quantityVal = quantity.value;
            let netPriceVal = netPrice.value;
            let taxRateVal = taxRate.value;
            if (quantityVal && netPriceVal && taxRateVal) {
                quantityVal = parseInt(quantityVal);
                netPriceVal = parseFloat(netPriceVal);
                taxRateVal = parseFloat('0.' + taxRateVal);
                if (quantityVal !== 0 && netPriceVal !== 0 && taxRateVal !== 0) {
                    taxValue.value = (quantityVal * netPriceVal * taxRateVal).toFixed(2);
                } else {
                    taxValue.value = '';
                }
            }
        }
        quantity.addEventListener('change', () => {
            calculate();
        })
        netPrice.addEventListener('change', () => {
            calculate();
        })
        taxRate.addEventListener('change', () => {
            calculate()
        })
    }

    calculateGrossValue(quantity, netPrice, taxRate, netValue, taxValue, grossValue) {
        let calculate = () => {
            let taxValueVal = taxValue.value;
            let netValueVal = netValue.value;
            if (taxValueVal && netValueVal) {
                taxValueVal = parseFloat(taxValueVal);
                netValueVal = parseFloat(netValueVal);
                if (taxValueVal !== 0 && netValueVal !== 0) {
                    grossValue.value = netValueVal + taxValueVal;
                } else {
                    grossValue.value = '';
                }
            }
        }
        quantity.addEventListener('change', () => {
            calculate();
        })
        netPrice.addEventListener('change', () => {
            calculate();
        })
        taxRate.addEventListener('change', () => {
            calculate()
        })
    }

    deleteProduct(el) {
        el.addEventListener('click', () => {
            el.parentNode.parentNode.remove();
            this.toggleDeleteButtons();
        })
    }

    toggleDeleteButtons() {
        const deleteButtons = document.getElementsByClassName("fa-solid fa-xmark delete-product-icon");
        if (deleteButtons.length > 1) {
            Array.from(deleteButtons).forEach((el) => {
                el.style.display = 'block'
            })
        } else {
            Array.from(deleteButtons).forEach((el) => {
                el.style.display = 'none'
            })
        }
    }
}