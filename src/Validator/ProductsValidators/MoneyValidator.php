<?php

namespace App\Validator\ProductsValidators;

use App\Model\Products;
use App\Validator\ClientsValidators\Nip;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class MoneyValidator extends ConstraintValidator
{
    public function __construct(Security $security,RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $this->security = $security;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof Nip) {
            throw new UnexpectedTypeException($constraint, Money::class);
        }

        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) to take care of that
        if (null === $value || '' === $value) {
            return;
        }

        if (!is_float($value)) {
            throw new UnexpectedValueException($value, 'float');

        }

        // access your configuration options like this:
        if ('strict' === $constraint->mode) {
            // ...
        }

        $userProductsNames = Products::query()
            ->where('USER_ID', $this->security->getUser()->getId())
            ->when($this->requestStack->getCurrentRequest()->attributes->get('id') !== null,function(Builder $query){
                $query->whereNot('ID', $this->requestStack->getCurrentRequest()->attributes->get('id'));
            })
            ->where('NAME', $value)
            ->first();

        if (!preg_match('/^\-?[0-9]+(?:\.[0-9]{1,2})?$/', $value, $matches)) {
            // the argument must be a string or an object implementing __toString()
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }
}
