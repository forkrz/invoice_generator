<?php

namespace App\Service;

use App\Model\Clients;
use App\Model\Products;
use Illuminate\Database\Eloquent\Collection;

class InvoiceHelper
{
    public function getClientsListForUser(int $userId): Collection
    {
        return Clients::query()
            ->where('USER_ID', $userId)
            ->get();
    }

    public function getProductsListForUser(int $userId): Collection
    {
        return Products::query()
            ->where('USER_ID', $userId)
            ->get();
    }

}