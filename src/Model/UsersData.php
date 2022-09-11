<?php


namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as CustomValidators;

class UsersData extends Model
{
    public $casts = [
        'username' => 'string',
        'password' => 'string',
        'INVOICE_UNIQUE_KEY' => 'string',
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
     */
    public function getName()
    {
        return $this->NAME;
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
     * @CustomValidators\ClientsUsersValidators\ZipCode(mode="loose")
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
    protected $guarded = [];

}