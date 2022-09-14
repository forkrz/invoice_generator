<?php

namespace App\Service\DbHelpers;

use App\Interfaces\DbHelpersInterface;
use App\Model\Clients;
use Illuminate\Database\Eloquent\Collection;

class ClientHelper implements DbHelpersInterface
{
    public function getListForUser(int $userId): Collection
    {
        return Clients::query()
            ->where('USER_ID', $userId)
            ->get();
    }

    public function createRecord(int $userId, array $data): ?int
    {
        // TODO: Implement createRecord() method.
    }
}