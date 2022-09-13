<?php

namespace App\Controller;

use App\Model\Users;
use App\Form\RegistrationFormType;
use App\Security\LoginAuthenticator;
use AppBundle\Model\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, LoginAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new Users();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $uniqueKeys = Users::query()
                ->get()
                ->pluck('INVOICE_UNIQUE_KEY')
                ->toArray();

            function checkUniqnessOfHash($uniqueKeys, $user)
            {
                $newUniqueKey = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
                if (in_array($newUniqueKey, $uniqueKeys)) {
                    checkUniqnessOfHash($uniqueKeys, $user);
                } else {
                    $user->INVOICE_UNIQUE_KEY = $newUniqueKey;
                }
            }
            checkUniqnessOfHash($uniqueKeys, $user);
            // encode the plain password
            $user->password = $userPasswordHasher->hashPassword($user, $form->get('plainPassword')->getData());
            $user->save();
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
