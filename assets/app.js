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

import {userMasks, clientMasks, firstProductMask} from "./js/Masks";
import {Clients} from "./js/Clients";
import {Products} from "./js/Products";
import {Dates} from "./js/Dates";

const clients = new Clients();
const products = new Products();
const dates = new Dates();


clients.showClientDataFromList();
products.addNewProductInput();
products.calculateNetValue(document.getElementById('client_user_date_invoice_form_Product___name___Quantity'), document.getElementById('client_user_date_invoice_form_Product___name___NET_PRICE'), document.getElementById('client_user_date_invoice_form_Product___name___NET_VALUE'));
dates.setDefaultMasks();
// products.fillProductData(document.querySelectorAll('.product-select')[document.querySelectorAll('.product-select').length - 1]);
