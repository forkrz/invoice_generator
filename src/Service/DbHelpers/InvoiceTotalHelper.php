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

    public function createRecord(int $userId, array $data): int
    {
        $newRecord = new InvoicesTotal();
        $newRecord->user_id = $userId;
        $newRecord->NAME = $data['name'];
        $newRecord->user_nip = $data['user_nip'];
        $newRecord->user_name = $data['user_name'];
        $newRecord->user_street = $data['user_street'];
        $newRecord->user_zip_code = $data['user_zip_code'];
        $newRecord->user_city = $data['user_city'];
        $newRecord->user_email = $data['user_email'];
        $newRecord->client_id = $data['client_id'];
        $newRecord->client_nip = $data['client_nip'];
        $newRecord->client_name = $data['client_name'];
        $newRecord->client_street = $data['client_street'];
        $newRecord->client_zip_code = $data['client_zip_code'];
        $newRecord->client_city = $data['client_city'];
        $newRecord->client_email = $data['client_email'];
        $newRecord->date_of_issue = $data['date_of_issue'];
        $newRecord->pay_by = $data['pay_by'];
        $newRecord->realised_on = $data['realised_on'];
        $newRecord->net_value = $data['net_value'];
        $newRecord->vat_value = $data['vat_value'];
        $newRecord->gross_value = $data['gross_value'];
        $newRecord->save();
        return $newRecord->id;
    }

    public function countInvoicesCreatedOnSpecificDay($date, int $userId): int
    {
        return InvoicesTotal::query()
            ->where('USER_ID', $userId)
            ->where('DATE_OF_ISSUE', $date)
            ->count();
    }
}