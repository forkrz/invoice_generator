/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

import WebFont from "webfontloader";
WebFont.load({google: {families: ["Roboto:300,400,500"]}});

// any CSS you import will output into a single css file (app.scss in this case)
import './styles/app.scss';

// start the Stimulus application



import {Clients} from "./js/Clients";
import {Products} from "./js/Products";
import {Dates} from "./js/Dates";
import {Validators} from "./js/Validators";

const clients = new Clients();
const products = new Products();
const dates = new Dates();
const validators = new Validators();

products.init();
clients.showClientDataFromList();
dates.setDefaultMasks();
validators.init();