<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as CustomValidators;

class InvoicesProducts extends Model
{

    public $casts = [
        'INVOICE_ID' => 'integer',
        'PRODUCT_ID' => 'integer',
        'PRODUCT_NAME' => 'string',
        'NET_PRICE' => 'float',
        'TAX_RATE' => 'integer',
        'Quantity' => 'integer',
    ];
}