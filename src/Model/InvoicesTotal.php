<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as CustomValidators;

class InvoicesTotal extends Model
{
    public $casts = [
        'USER_ID' => 'integer',
        'NAME' => 'string',
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
        'NET_PRICE' => 'float',
        'NET_VALUE' => 'float',
        'TAX_VALUE' => 'float',
        'GROSS_VALUE' => 'float',
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
     * @CustomValidators\ClientsUsersValidators\Nip(mode="invoice")
     */
    public function getClientNip()
    {
        return $this->CLIENT_NIP;
    }

    /**
     * @Assert\NotBlank
     * @CustomValidators\ClientsUsersValidators\ClientName(mode="invoice")
     */
    public function getClientName()
    {
        return $this->CLIENT_NAME;
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

    public function getNetPrice()
    {
        return $this->NET_PRICE;
    }

    public function getGrossUnitPrice()
    {
        return $this->GROSS_UNIT_PRICE;
    }

    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];
    protected $table = 'invoices_total';
}