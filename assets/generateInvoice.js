import {Clients} from "./js/invoice/Clients";
import {Products} from "./js/invoice/Products";
import {Dates} from "./js/invoice/Dates";
import {Validators} from "./js/invoice/Validators";

const clients = new Clients();
const products = new Products();
const dates = new Dates();
const validators = new Validators();

products.init();
clients.showClientDataFromList();
dates.setDefaultMasks();
validators.init();