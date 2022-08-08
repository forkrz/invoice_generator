export class Products{

    addNewProductInput(){
        const productsList = document.getElementById('products-list');
        const inputDiv = productsList.getElementsByTagName('div')[3];
        const addProductButton = document.getElementById('add-product-button');
        addProductButton.addEventListener('click',(e) =>{
            e.preventDefault();
            const lastDiv = Array.from(productsList.querySelectorAll('.product-container')).pop();
            let NewProductInput = inputDiv.cloneNode(true);
            const currentIndex = parseInt(lastDiv.dataset.index);
            NewProductInput.dataset.index = currentIndex + 1;

            NewProductInput.querySelectorAll('div').forEach((el) =>{
                el.id = el.id.replace('__name__', currentIndex +1);
                el.querySelectorAll('input').forEach((elChild) => {
                    elChild.id = elChild.id.replace('__name__', currentIndex + 1);
                    elChild.name = elChild.name.replace('__name__', currentIndex + 1);
                    elChild.value = '';
                })
            });

            productsList.append(NewProductInput);
            this.fillProductData(document.querySelectorAll('.product-select')[document.querySelectorAll('.product-select').length - 1]);
        })
    }

    fillProductData(el) {
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
        })
    }
}