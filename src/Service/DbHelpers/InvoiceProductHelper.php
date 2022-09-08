<?php

namespace App\Service\DbHelpers;

use App\Interfaces\DbHelpersInterface;
use Illuminate\Database\Eloquent\Collection;

class InvoiceProductHelper implements DbHelpersInterface
{
    public function getListForUser(int $userId): Collection
    {
        // TODO: Implement getListForUser() method.
    }
}