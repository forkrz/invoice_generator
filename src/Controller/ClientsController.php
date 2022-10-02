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
     * @Route("/clients/create", name="create_client")
     */
    public function create(Request $request, ValidatorInterface $validator):Response
    {
        if($this->getUser() === null)
        {
            return new Response($this->redirectToRoute('app_login'));
        }
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

                $this->addFlash('success', 'Client created');
                return new Response($this->redirectToRoute('clients/show'));
            }


            $errors = [];

            foreach($validator->validate($form) as $error){
                $fieldName = substr($error->getPropertyPath(),5);
                $errors[] = [$fieldName => $error->getMessage()];
            }

            $errors = array_merge(...$errors);

            return new Response($this->renderView('Clients/create.html.twig', [
                'clients_form' => $form->createView(),
                'errors' => $errors,
            ]));
    }

    /**
     * @Route("/clients/show", name="clients/show")
     */
    public function show():Response
    {
        if($this->getUser() === null)
        {
            return new Response($this->redirectToRoute('app_login'));
        }

        $userClientsData = Clients::query()
            ->where('USER_ID', $this->getUser()->getId())
            ->get()
            ->toArray();

        if(empty($userClientsData)){
            return new Response($this->renderView('Clients/show.html.twig', [
                'msgEmptyList' => 'You do not have any clients. You can add them&nbsp;',
                'msgLink' => $this->generateUrl('create_client'),
            ]));
        }

        return new Response($this->renderView('Clients/show.html.twig', [
            'clientsData' => $userClientsData,
        ]));
    }

    /**
     * @Route("/clients/update/id={id}", name="update_client")
     */
    public function update($id, Request $request,ValidatorInterface $validator):Response
    {
        if($this->getUser() === null)
        {
            return new Response($this->redirectToRoute('app_login'));
        }
        $editedClientData = Clients::query()
            ->where('ID', $id)
            ->where('USER_ID',$this->getUser()->getId())
            ->select('NIP','COMPANY_NAME','STREET','ZIP_CODE','CITY','EMAIL')
            ->first();

        $clientDataToCompare = clone $editedClientData;

        if(empty($editedClientData))
        {
            $this->addFlash('error', 'You are not allowed to edit these client');
            return new Response($this->redirectToRoute('clients/show'));
        }

        $form = $this->createForm(ClientsFormType::class, $editedClientData);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $formData = $request->request->all()['clients_form'];
            $formDataKeysNotToEdit = ['Submit','_token'];
            $formDataToCheck = array_diff_key($formData, array_flip($formDataKeysNotToEdit));
            $fieldsToUpdate = array_diff_assoc($formDataToCheck, $clientDataToCompare->toArray());

            if(empty($fieldsToUpdate)){
                $this->addFlash('error', 'There is nothing to change');
                return new Response($this->redirectToRoute('clients/show'));
            }

            Clients::query()
                ->where('ID', $id)
                ->where('USER_ID',$this->getUser()->getId())
                ->update($fieldsToUpdate);

            $this->addFlash('success', 'Client data updated');
            return new Response($this->redirectToRoute('clients/show'));

        }

        $errors = [];

        foreach($validator->validate($form) as $error){
            $fieldName = substr($error->getPropertyPath(),5);
            $errors[] = [$fieldName => $error->getMessage()];
        }

        $errors = array_merge(...$errors);

        return new Response($this->renderView('Clients/edit.html.twig', [
            'clientData' => $editedClientData,
            'clients_form' => $form->createView(),
            'errors' => $errors,
        ]));
    }

    /**
     * @Route("/clients/delete/id={id}", name="delete_client")
     */
    public function delete($id):Response
    {
        if($this->getUser() === null)
        {
            return new Response($this->redirectToRoute('app_login'));
        }
        $editedClientData = Clients::query()
            ->where('ID', $id)
            ->where('USER_ID',$this->getUser()->getId())
            ->first();

        if(empty($editedClientData))
        {
            $this->addFlash('error', 'You are not allowed to delete these client');
            return new Response($this->redirectToRoute('clients/show'));
        }

        Clients::query()
            ->where('ID', $id)
            ->where('USER_ID',$this->getUser()->getId())
            ->delete();

        $this->addFlash('success', 'Client has been deleted');
        return new Response($this->redirectToRoute('clients/show'));
    }

}
