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

import IMask from 'imask';

var Nip = document.getElementById('NIP');
var NipmaskOptions = {
    mask: '00000000000'
};

var Zip = document.getElementById('ZIP');
var ZipmaskOptions = {
    mask: '00-000'
};

var Nipmask = IMask(Nip, NipmaskOptions);
var Zipmask = IMask(Zip, ZipmaskOptions);

