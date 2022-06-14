<?php


namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class UsersData extends Model
{
    public $casts = [
        'NIP' => 'integer',
        'NAME' => 'string',
        'STREET' => 'string',
        'ZIP_CODE' => 'string',
        'CITY' => 'string',
        'EMAIL' => 'string',
    ];

    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

}