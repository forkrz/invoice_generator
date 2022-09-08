<?php

namespace App\Service\DbHelpers;

use App\Interfaces\DbHelpersInterface;
use App\Model\Products;
use Illuminate\Database\Eloquent\Collection;

class ProductHelper implements  DbHelpersInterface
{
    public function getListForUser(int $userId): ?Collection
    {
        return Products::query()
            ->where('USER_ID', $userId)
            ->get();
    }
}