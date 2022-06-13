<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as CustomValidators;

class Products extends Model
{
    public $casts = [
        'Name' => 'string',
        'NET_PRICE' => 'float',
    ];

    /**
     * @Assert\NotBlank
     */
    public function getName(){
        return $this->NAME;
    }

    /**
     * @Assrt\NotBlank
     * @CustomValidators\ProductsValidators\Money(mode="loose")
     */

    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];
}