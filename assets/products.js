import {Products} from "./js/products/products";
import IMask from "imask";

const products = new Products();

let netPriceMask = IMask(
    document.getElementById('NET_PRICE'),
    {
        mask: Number,
        min: 1,
        max: 9999,
        scale: 2,
        signed: false,
        radix: '.'
    });

let taxRateMask = IMask(
    document.getElementById('TAX_RATE'),
    {
        mask: Number,
        min: 1,
        max: 99,
        scale: 0,
        signed: false
    });

products.init();