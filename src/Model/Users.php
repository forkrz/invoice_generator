<?php

namespace App\Model;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Illuminate\Database\Eloquent\Model;

class Users extends Model implements UserInterface, PasswordAuthenticatedUserInterface
{
    public $fillable = ['username', 'password', 'roles'];

    public function getId()
    {
       return $this->id;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles = array();
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getUserIdentifier(): string
    {
        return $this->username;
    }

    public function eraseCredentials()
    {
    }
    public $timestamps = false;
}