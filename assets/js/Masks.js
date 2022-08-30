import IMask from 'imask';

export let userMasks = {};
export let clientMasks = {};
export let dateMasks = {};

userMasks.userNipMask = IMask(
    document.getElementById('client_user_date_invoice_form_USER_NIP'),
    {
        mask: '00000000000',
    });
clientMasks.clientNipMask = IMask(
    document.getElementById('client_user_date_invoice_form_CLIENT_NIP'),
    {
        mask: '00000000000',
    });

userMasks.userZipCodeMask = IMask(
    document.getElementById('client_user_date_invoice_form_USER_ZIP_CODE'),
    {
        mask: '00-000'
    });

clientMasks.clientZipCodeMask = IMask(
    document.getElementById('client_user_date_invoice_form_CLIENT_ZIP_CODE'),
    {
        mask: '00-000'
    });

dateMasks.creationDateMask = IMask(
    document.getElementById('client_user_date_invoice_form_DATE_OF_ISSUE'),
    {
        mask: Date,
        min: new Date(new Date().getFullYear(), 0, 1),
        max: new Date(9999, 0, 1),
        lazy: false
    });

dateMasks.paidToMask = IMask(
    document.getElementById('client_user_date_invoice_form_PAY_BY'),
    {
        mask: Date,
        min: new Date(new Date().getFullYear(), 0, 1),
        max: new Date(9999, 0, 1),
        lazy: false
    });

dateMasks.serviceDateMask = IMask(
    document.getElementById('client_user_date_invoice_form_REALISED_ON'),
    {
        mask: Date,
        min: new Date(new Date().getFullYear(), 0, 1),
        max: new Date(9999, 0, 1),
        lazy: false
    });
