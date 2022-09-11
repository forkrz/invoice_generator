<?php

namespace App\Validator\ProductsValidators;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */

class ProductName extends Constraint
{
    public $message = 'You already have Product with this name.';
    public $mode;

    public function getRequiredOptions(): array
    {
        return ['mode'];
    }

}
