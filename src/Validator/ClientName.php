<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */

class ClientName extends Constraint
{
    public $message = 'You already have Client with this name.';
    public $mode;

    public function getRequiredOptions(): array
    {
        return ['mode'];
    }

}