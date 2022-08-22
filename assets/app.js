/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.scss in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';


import {Clients} from "./js/Clients";
import {Products} from "./js/Products";
import {Dates} from "./js/Dates";

const clients = new Clients();
const products = new Products();
const dates = new Dates();


clients.showClientDataFromList();
clients.loadMasks();

products.addNewProductInput();
products.loadMasks();

dates.loadMasks();

// products.fillProductData(document.querySelectorAll('.product-select')[document.querySelectorAll('.product-select').length - 1]);
