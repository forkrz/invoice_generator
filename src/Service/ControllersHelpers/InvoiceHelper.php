<?php

namespace App\Service\ControllersHelpers;

use App\Service\DbHelpers\ClientHelper;
use App\Service\DbHelpers\InvoiceTotalHelper;
use App\Service\DbHelpers\ProductHelper;
use App\Service\DbHelpers\UserHelper;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\Security;

class InvoiceHelper
{
    private $security;
    private $userHelper;
    private $invoiceTotalHelper;
    private $productHelper;
    private $clientHelper;

    public function __construct(Security $security, UserHelper $userHelper, InvoiceTotalHelper $invoiceTotalHelper, ProductHelper $productHelper,ClientHelper $clientHelper)
    {
        $this->security = $security;
        $this->userHelper = $userHelper;
        $this->invoiceTotalHelper = $invoiceTotalHelper;
        $this->productHelper = $productHelper;
        $this->clientHelper = $clientHelper;
    }

    public function prepareInvoiceTotalData(FormInterface $form): array
    {
        $formData = $form->getData();
        $productsData = $formData->Product;
        $invoiceKey = $this->userHelper->getInvoiceUniqueKey();
        $invoiceQuantity = $this->invoiceTotalHelper->countInvoicesCreatedOnSpecificDay($formData['DATE_OF_ISSUE']->format('Y-m-d'), $this->security->getUser()->getId());
        $totalNetValue = $this->getTotalNetValue($productsData);
        $totalTaxValue = $this->getTotalTaxValue($productsData);
        $totalGrossValue = $totalNetValue + $totalTaxValue;
        $invoiceName = $this->getInvoiceName($invoiceKey, $invoiceQuantity, $formData['DATE_OF_ISSUE']->format('Y-m-d'));
        $clientData = $this->clientHelper->getListForUser($this->security->getUser()->getId())->where('COMPANY_NAME', $formData->CLIENT_NAME);
        $clientData->isNotEmpty() ? $clientId = $clientData->first()->ID : $clientId = '';

        $result = [];
        $result['user_nip'] = $formData->USER_NIP;
        $result['name'] = $invoiceName;
        $result['user_name'] = $formData->USER_NAME;
        $result['user_street'] = $formData->USER_STREET;
        $result['user_zip_code'] = $formData->USER_ZIP_CODE;
        $result['user_city'] = $formData->USER_CITY;
        $result['user_email'] = $formData->USER_EMAIL;
        $result['client_id'] = $clientId;
        $result['client_nip'] = $formData->CLIENT_NIP;
        $result['client_name'] = $formData->CLIENT_NAME;
        $result['client_street'] = $formData->CLIENT_STREET;
        $result['client_zip_code'] = $formData->CLIENT_ZIP_CODE;
        $result['client_city'] = $formData->CLIENT_CITY;
        $result['client_email'] = $formData->CLIENT_EMAIL;
        $result['date_of_issue'] = $formData->DATE_OF_ISSUE->format('Y-m-d');
        $result['pay_by'] = $formData->PAY_BY->format('Y-m-d');
        $result['realised_on'] = $formData->REALISED_ON->format('Y-m-d');
        $result['net_value'] = $totalNetValue;
        $result['vat_value'] = $totalTaxValue;
        $result['gross_value'] = $totalGrossValue;
        return $result;
    }

    private function getTotalNetValue($productsData): float
    {
        $netValuePerProduct = array_map(function ($val) {
            return $val['NET_PRICE'] * $val['Quantity'];
        }, $productsData);
        return array_sum($netValuePerProduct);
    }

    private function getTotalTaxValue($productsData): float
    {
        $netValuePerProduct = array_map(function ($val) {
            return $val['NET_PRICE'] * $val['Quantity'] * $val['TAX_RATE'] / 100;
        }, $productsData);
        return array_sum($netValuePerProduct);
    }

    private function getInvoiceName(string $userUniqueKey, int $invoiceQuantity, string $creationDate): string
    {
        return $userUniqueKey . '/' . $invoiceQuantity + 1 . '/' . $creationDate;
    }

    public function prepareInvoiceProductsData(int $invoiceId, FormInterface $form): array
    {
        $userProducts = $this->productHelper->getListForUser($this->security->getUser()->getId());
        $products = $form->getData()->Product;
         return array_map(function ($el) use($invoiceId, $userProducts){
            $productId = '';
            if(!$userProducts->isEmpty()){
                $productData = $userProducts->where('NAME',$el['NAME']);
                !$productData->isEmpty() ? $productId =  $productData->first()->ID : '';
            }
            $netValue = $el['NET_PRICE'] * $el['Quantity'];
            $taxValue = $el['NET_PRICE'] * $el['Quantity'] * $el['TAX_RATE'] / 100;
            $grossValue = $netValue + $taxValue;

            return[
                'invoice_id' => $invoiceId,
                'product_id' => $productId,
                'product_name' => $el['NAME'],
                'net_price' => $el['NET_PRICE'],
                'tax_rate' => $el['TAX_RATE'],
                'quantity' => $el['Quantity'],
                'net_value' => $netValue,
                'tax_value' => $taxValue,
                'gross_value' => $grossValue,

            ];
        }, $products);
    }

}