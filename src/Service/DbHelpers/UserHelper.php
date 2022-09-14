<?php

namespace App\Service\DbHelpers;

use App\Interfaces\DbHelpersInterface;
use App\Model\Users;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\Security\Core\Security;

class UserHelper implements DbHelpersInterface
{
    private $security;
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function createRecord(int $userId, array $data): int
    {
        // TODO: Implement createRecord() method.
    }

    public function getListForUser(int $userId): ?Collection
    {
        return Users::query()
            ->where('ID', $userId)
            ->get();
    }

    public function getInvoiceUniqueKey(): string
    {
        return Users::query()
            ->where('ID', $this->security->getUser()->getId())
            ->first()
            ->INVOICE_UNIQUE_KEY;
    }
}