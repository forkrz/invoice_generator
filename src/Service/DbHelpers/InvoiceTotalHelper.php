<?php

namespace App\Service\DbHelpers;

use App\Interfaces\DbHelpersInterface;
use App\Model\InvoicesTotal;
use Illuminate\Database\Eloquent\Collection;

class InvoiceTotalHelper implements DbHelpersInterface
{
    public function getListForUser(int $userId): Collection
    {
        // TODO: Implement getListForUser() method.
    }

    public function createRecord(int $userId, array $data): ?bool
    {
        $product = new InvoicesTotal();

    }
}