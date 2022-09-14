import {Settings} from "./js/user/Settings";
import IMask from "imask";

const settings = new Settings();

const nipMask = IMask(
    document.getElementById('NIP'),
    {
        mask: '00000000000'
    });

const zipCodeMask = IMask(
    document.getElementById('ZIP'),
    {
        mask: '00-000'
    });

settings.init();