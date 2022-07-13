<?php

use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    public $casts = [
        'USER_ID' => 'integer',
        'CLIENT_ID' => 'integer',
        'DATE_OF_ISSUE' => 'date:Y-m-d',
        'PAY_BY' => 'date:Y-m-d',
        'REALISED_ON' => 'date:Y-m-d',
        'PRODUCT_ID' => 'integer',
        'TAX_RATE' => 'float',
        'NET_PRICE' => 'float',
        'GROSS_UNIT_PRICE' => 'float',
        'PRODUCT_NAME' => 'string',
        'QUANTITY' => 'int',
        'INVOICE_NUMBER' => 'string',
        'TOTAL_GROSS_PRICE' => 'float',
    ];

    public function getDateOfIssue()
    {
        return $this->DATE_OF_ISSUE;
    }

    public function getPayBy()
    {
        return $this->PAY_BY;
    }

    public function getRealisedOn()
    {
    return $this->REALISED_ON;
    }

    public function getTaxRate()
    {
        return $this->TAX_RATE;
    }

    public function getNetPrice()
    {
        return $this->NET_PRICE;
    }

    public function getGrossUnitPrice()
    {
        return $this->GROSS_UNIT_PRICE;
    }

    public function getProductName()
    {
        return $this->PRODUCT_NAME;
    }

    public function getQuantity()
    {
        return $this->QUANTITY;
    }

    public function getInvoiceNumber()
    {
        return $this->INVOICE_NUMBER;
    }

    public function getTotalGrossPrice()
    {
        return $this->TOTAL_GROSS_PRICE;
    }

    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];
}