<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    public $casts = [
        'Name' => 'string',
        'NET_PRICE' => 'float',
    ];

    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];
}