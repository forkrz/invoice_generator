<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as CustomValidators;

class Invoices extends Model
{
    public $casts = [
        'USER_ID' => 'integer',
        'USER_NIP' => 'integer',
        'USER_NAME' => 'string',
        'USER_STREET' => 'string',
        'USER_ZIP_CODE' => 'string',
        'USER_CITY' => 'string',
        'USER_EMAIL' => 'string',
        'CLIENT_ID' => 'integer',
        'CLIENT_NIP' => 'integer',
        'CLIENT_NAME' => 'string',
        'CLIENT_STREET' => 'string',
        'CLIENT_ZIP_CODE' => 'string',
        'CLIENT_CITY' => 'string',
        'CLIENT_EMAIL' => 'string',
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

    /**
     * @Assert\NotBlank(message = "Nip number must be exactly 10 characters long")
     * @Assert\Length(
     *      min = 10,
     *      max = 10,
     *     minMessage = "Nip number must be exactly {{ limit }} characters long",
     *     maxMessage = "Nip number must be exactly {{ limit }} characters long",
     * )
     */
    public function getUserNip()
    {
        return $this->USER_NIP;
    }

    /**
     * @Assert\NotBlank
     */
    public function getUserName()
    {
        return $this->USER_NAME;
    }

    /**
     * @Assert\NotBlank
     */
    public function getUserStreet()
    {
        return $this->USER_STREET;
    }

    /**
     * @Assert\NotBlank
     * @CustomValidators\ClientsUsersValidators\ZipCode(mode="loose")
     */
    public function getUserZipCode()
    {
        return $this->USER_ZIP_CODE;
    }

    /**
     * @Assert\NotBlank
     */
    public function getUserCity(){
        return $this->USER_CITY;
    }

    /**
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     */
    public function getUserEmail()
    {
        return $this->User_EMAIL;
    }

    /**
     * @Assert\NotBlank(message = "Nip number must be exactly 10 characters long")
     * @Assert\Length(
     *      min = 10,
     *      max = 10,
     *     minMessage = "Nip number must be exactly {{ limit }} characters long",
     *     maxMessage = "Nip number must be exactly {{ limit }} characters long",
     * )
     * @CustomValidators\ClientsUsersValidators\Nip(mode="client")
     */
    public function getClientNip()
    {
        return $this->CLIENT_NIP;
    }

    /**
     * @Assert\NotBlank
     * @CustomValidators\ClientsUsersValidators\ClientName(mode="client")
     */
    public function getClientCompanyName()
    {
        return $this->CLIENT_COMPANY_NAME;
    }

    /**
     * @Assert\NotBlank
     */
    public function getClientStreet()
    {
        return $this->CLIENT_STREET;
    }

    /**
     * @Assert\NotBlank
     * @CustomValidators\ClientsUsersValidators\ZipCode(mode="loose")
     */
    public function getClientZipCode()
    {
        return $this->CLIENT_ZIP_CODE;
    }

    /**
     * @Assert\NotBlank
     */
    public function getClientCity(){
        return $this->CLIENT_CITY;
    }

    /**
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     */
    public function getClientEmail()
    {
        return $this->CLIENT_EMAIL;
    }

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