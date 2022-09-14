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
}