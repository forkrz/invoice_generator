<?php

namespace App\Controller;

use App\Model\Users;
use App\Form\RegistrationFormType;
use App\Security\LoginAuthenticator;
use Symfony\Component\Security\Core\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, LoginAuthenticator $authenticator, Security $security): Response
    {
        if ($security->getUser() !== null) {
            return $this->redirectToRoute('invoice/show');
        }
        $user = new Users();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $uniqueKeys = Users::query()
                ->get()
                ->pluck('INVOICE_UNIQUE_KEY')
                ->toArray();

            $loginCheck = Users::query()
                ->where('username', $form->get('username')->getData())
                ->get();

            if($loginCheck->isNotEmpty()) {
                $this->addflash('error', 'User with this name already exists.');
                return $this->redirectToRoute('app_register');
            }

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
            $user->password = $userPasswordHasher->hashPassword($user, $form->get('password')->getData());
            $user->save();
            // do anything else you need here, like send an email
            $this->addflash('success', 'Registration successful.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
