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