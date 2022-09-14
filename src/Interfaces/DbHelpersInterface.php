<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface DbHelpersInterface
{
    /**
     * return list of clients,products etc. basing on class for user.
     */
    public function getListForUser(int $userId): ?Collection;

    /**
     * create record in table according to class with specified user id and return its id.
     */
    public function createRecord(int $userId, array $data): ?int;
}