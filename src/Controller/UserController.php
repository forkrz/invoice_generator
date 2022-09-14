<?php

namespace App\Controller;

use App\Form\UsersDataFormType;
use App\Model\UsersData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Request;

Class UserController extends AbstractController
{
    /**
     * @Route("/settings/", name="user_settings")
     */
    public function settings(Request $request,ValidatorInterface $validator):Response
    {
        if($this->getUser() === null)
        {
            return $this->render('security/login.html.twig');
        }

        $userSettings = UsersData::query()
            ->where('USER_ID', $this->getUser()->getId())
            ->first();

        $form = $this->createForm(UsersDataFormType::class, $userSettings);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $formData = $request->request->all()['users_data_form'];

            if($userSettings === null){
                $settings = new UsersData();
                $settings->NIP = $formData['NIP'];
                $settings->NAME = $formData['NAME'];
                $settings->STREET = $formData['STREET'];
                $settings->ZIP_CODE = $formData['ZIP_CODE'];
                $settings->CITY = $formData['CITY'];
                $settings->EMAIL = $formData['EMAIL'];
                $settings->User_ID = $this->getuser()->getId();
                $settings->save();
            }else{
                $formDataKeysNotToEdit = ['Submit','_token'];
                $formDataToUpdate = array_diff_key($formData, array_flip($formDataKeysNotToEdit));

                UsersData::query()
                    ->where('USER_ID', $this->getUser()->getId())
                    ->update($formDataToUpdate);
            }

            $this->addFlash('success', 'User settings updated');
            return new Response($this->redirectToRoute('show_clients'));
        }

        $errors = [];

        foreach($validator->validate($form) as $error){
            $fieldName = substr($error->getPropertyPath(),5);
            $errors[] = [$fieldName => $error->getMessage()];
        }

        $errors = array_merge(...$errors);

        return new Response($this->render('users/Settings.html.twig',['userSettings' => $userSettings,
            'user_settings_form' => $form->createView(),
            'errors' => $errors]));
    }
}