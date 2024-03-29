<?php

namespace App\Validator\ClientsUsersValidators;

use App\Model\Clients;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Symfony\Component\HttpFoundation\RequestStack;

class NipValidator extends ConstraintValidator
{
    public function __construct(Security $security,RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $this->security = $security;
    }

    public function validate($value, Constraint $constraint)
    {

        if (!$constraint instanceof Nip) {
            throw new UnexpectedTypeException($constraint, Nip::class);
        }

        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) to take care of that
        if (null === $value || '' === $value) {
            return;
        }

        if (!is_int($value)) {
            throw new UnexpectedValueException($value, 'int');

        }

        if ($constraint->mode === 'client') {
            $userClientsNips = Clients::query()
                ->where('USER_ID', $this->security->getUser()->getId())
                ->when($this->requestStack->getCurrentRequest()->attributes->get('id') !== null,function(Builder $query){
                    $query->whereNot('ID', $this->requestStack->getCurrentRequest()->attributes->get('id'));
                })
                ->where('NIP', $value)
                ->first();

            if (!is_null($userClientsNips)) {
                // the argument must be a string or an object implementing __toString()
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ string }}', $value)
                    ->addViolation();
            }
        }
    }
}