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
     * @CustomValidators\ProductsValidators\ProductName(mode="loose")
     */
    public function getName(){
        return $this->NAME;
    }

    /**
     * @Assert\NotBlank
     * @CustomValidators\ProductsValidators\Money(mode="loose")
     */
    public function getPrice(){
        return $this->PRICE;
    }

    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];
}