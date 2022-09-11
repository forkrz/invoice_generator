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

class ClientNameValidator extends ConstraintValidator
{
    public function __construct(Security $security, RequestStack $requestStack)
    {
        $this->security = $security;
        $this->requestStack = $requestStack;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ClientName) {
            throw new UnexpectedTypeException($constraint, ClientName::class);
        }

        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) to take care of that
        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');

        }

        // access your configuration options like this:
        if ($constraint->mode === 'client') {
            $userClientsIds = Clients::query()
                ->where('USER_ID', $this->security->getUser()->getId())
                ->when($this->requestStack->getCurrentRequest()->attributes->get('id') !== null,function(Builder $query){
                    $query->whereNot('ID', $this->requestStack->getCurrentRequest()->attributes->get('id'));
                })
                ->where('company_name', $value)
                ->first();

            if (!is_null($userClientsIds)) {
                // the argument must be a string or an object implementing __toString()
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ string }}', $value)
                    ->addViolation();
            }
        }
    }
}