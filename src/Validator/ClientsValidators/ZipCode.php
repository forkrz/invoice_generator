<?php
namespace App\Validator\ClientsValidators;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */

class ZipCode extends Constraint
{
    public $message = 'The string must be put in format 11-111';
    public $mode;

    public function getRequiredOptions(): array
    {
        return ['mode'];
    }

}