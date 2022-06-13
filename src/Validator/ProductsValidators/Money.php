<?php


namespace App\Validator\ProductsValidators;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Money extends Constraint
{
    public $message = 'Please insert amount in correct format';
    public $mode;

    public function getRequiredOptions(): array
    {
        return ['mode'];
    }

}
