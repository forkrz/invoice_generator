import IMask from "imask";

export class Products {

    addNewProductInput() {
        const productsList = document.getElementById('products-list');
        const inputDiv = productsList.getElementsByTagName('div')[3];
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
            });

            productsList.append(NewProductInput);
            const productContainer = document.querySelectorAll('.product-select')[document.querySelectorAll('.product-select').length - 1];
            let inputLists = productContainer.parentNode.parentNode.querySelectorAll('div');
            let netPriceMask = IMask(
                inputLists[1].querySelector('input'),
                {
                    mask: '00000.00'
                });
            let taxRateMask = IMask(
                inputLists[3].querySelector('input'),
                {
                    mask: '00'
                });
            this.fillProductData(productContainer, netPriceMask, taxRateMask);
            this.calculateNetValue(inputLists[1].querySelector('input'),inputLists[2].querySelector('input'),inputLists[4].querySelector('input'))
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
            const inputLists = productContainer.querySelectorAll('div');
            inputLists[0].querySelector('input').value = productData.name;
            inputLists[2].querySelector('input').value = productData.price;
            inputLists[3].querySelector('input').value = productData.tax;
            netPriceMask.updateValue();
            taxRateMask.updateValue();
        })
    }

    calculateNetValue(quantity, netPrice, netValue) {
        let calculate = () => {
            let quantityVal = quantity.value;
            let netPriceVal = netPrice.value;
            if(quantityVal && netPriceVal) {
                quantityVal = parseInt(quantityVal);
                netPriceVal = parseFloat(netPriceVal);
                if(quantityVal !== 0 && netPriceVal !== 0) {
                    netValue.value = quantityVal * netPriceVal;
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

}