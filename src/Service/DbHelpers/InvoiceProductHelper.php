<?php

namespace App\Service\DbHelpers;

use App\Interfaces\DbHelpersInterface;
use App\Model\InvoicesProducts;
use Illuminate\Database\Eloquent\Collection;

class InvoiceProductHelper implements DbHelpersInterface
{
    public function getListForUser(int $userId): Collection
    {
        // TODO: Implement getListForUser() method.
    }

    public function createRecord(int $userId, array $data): int
    {
        $newRecord = new InvoicesProducts();
        $newRecord->invoice_id = $data['invoice_id'];
        $newRecord->product_id = $data['product_id'];
        $newRecord->product_name = $data['product_name'];
        $newRecord->net_price = $data['net_price'];
        $newRecord->tax_rate = $data['tax_rate'];
        $newRecord->quantity = $data['quantity'];
        $newRecord->net_value = $data['net_value'];
        $newRecord->tax_value = $data['tax_value'];
        $newRecord->gross_value = $data['gross_value'];
        $newRecord->save();
        return $newRecord->id;
    }

    public function getDataForInvoice(int $userId, int $invoiceId): Collection
    {
        return InvoicesProducts::query()
            ->where('invoices_total.USER_ID', $userId)
            ->where('invoices_total.ID', $invoiceId)
            ->leftJoin('invoices_total', 'invoices_products.INVOICE_ID', '=', 'invoices_total.ID')
            ->select('invoices_total.NAME', 'invoices_total.USER_NIP', 'invoices_total.USER_NAME', 'invoices_total.USER_EMAIL', 'invoices_total.USER_STREET', 'invoices_total.USER_ZIP_CODE', 'invoices_total.USER_CITY', 'invoices_total.CLIENT_NAME', 'invoices_total.CLIENT_NIP', 'invoices_total.CLIENT_STREET', 'invoices_total.CLIENT_ZIP_CODE', 'invoices_total.CLIENT_CITY', 'invoices_total.CLIENT_EMAIL', 'invoices_total.DATE_OF_ISSUE', 'invoices_total.PAY_BY', 'invoices_total.REALISED_ON', 'invoices_total.NET_VALUE', 'invoices_total.VAT_VALUE', 'invoices_total.GROSS_VALUE', 'invoices_products.PRODUCT_NAME', 'invoices_products.NET_PRICE AS PRODUCT_NET_PRICE', 'invoices_products.TAX_RATE', 'invoices_products.QUANTITY', 'invoices_products.NET_VALUE AS PRODUCT_NET_VALUE', 'invoices_products.TAX_VALUE AS PRODUCT_TAX_VALUE', 'invoices_products.GROSS_VALUE AS PRODUCT_GROSS_VALUE')
            ->get();
    }
}