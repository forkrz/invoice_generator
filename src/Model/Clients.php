<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as CustomValidators;
class Clients extends Model
{
    public $casts = [
        'NIP' => 'integer',
        'COMPANY_NAME' => 'string',
        'STREET' => 'string',
        'ZIP_CODE' => 'string',
        'CITY' => 'string',
        'EMAIL' => 'string',
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
    public function getNip()
    {
        return $this->NIP;
    }

    /**
     * @Assert\NotBlank
     * @CustomValidators\ClientName(mode="loose")
     */
    public function getCompanyName()
    {
        return $this->COMPANY_NAME;
    }

    /**
     * @Assert\NotBlank
     */
    public function getStreet()
    {
        return $this->STREET;
    }

    /**
     * @Assert\NotBlank
     * @CustomValidators\ZipCode(mode="loose")
     */
    public function getZipCode()
    {
        return $this->ZIP_CODE;
    }

    /**
     * @Assert\NotBlank
     */
    public function getCity(){
        return $this->CITY;
    }

    /**
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     */
    public function getEmail()
    {
        return $this->EMAIL;
    }


    protected $primaryKey = 'id';
    public $timestamps = false;

}
