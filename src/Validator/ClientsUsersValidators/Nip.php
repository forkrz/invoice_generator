<?php

namespace App\Validator\ClientsUsersValidators;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */

class Nip extends Constraint
{
    public $message = 'You already have Client with this Nip.';
    public $mode;

    public function getRequiredOptions(): array
    {
        return ['mode'];
    }

}
