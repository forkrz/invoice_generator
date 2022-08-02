export class Products{

    addNewProductInput(){
        const productsList = document.getElementById('products-list');
        const inputDiv = productsList.getElementsByTagName('div')[1];
        const addProductButton = document.getElementById('add-product-button');
        addProductButton.addEventListener('click',(e) =>{
            e.preventDefault();
            const NewProductInput = inputDiv.cloneNode(true);
            productsList.append(NewProductInput);
        })
    }
}