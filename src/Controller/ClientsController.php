<?php

namespace App\Controller;

use App\Form\ClientsFormType;
use App\Model\Clients;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
Class ClientsController extends AbstractController
{

    /**
     * @Route("/clients/create", name='create_client')
     */
    public function create(Request $request, ValidatorInterface $validator):Response
    {
        $clients = new Clients();
        $form = $this->createForm(ClientsFormType::class, $clients);

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $formData = $request->request->all()['clients_form'];
                $client = new Clients();
                $client->NIP = $formData['NIP'];
                $client->COMPANY_NAME = $formData['COMPANY_NAME'];
                $client->STREET = $formData['STREET'];
                $client->ZIP_CODE = $formData['ZIP_CODE'];
                $client->CITY = $formData['CITY'];
                $client->EMAIL = $formData['EMAIL'];
                $client->User_ID = $this->getuser()->getId();
                $client->save();
            }


            $errors = [];

            foreach($validator->validate($form) as $error){
                $fieldName = substr($error->getPropertyPath(),5);
                $errors[] = [$fieldName => $error->getMessage()];
            }

            $errors = array_merge(...$errors);

            return new Response($this->render('/clients/create.html.twig', [
                'clients_form' => $form->createView(),
                'errors' => $errors,
            ]));
    }


}
