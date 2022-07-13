<?php

namespace App\Controller;

use App\Model\UsersData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InvoiceController extends AbstractController
{

    #[Route('/create', name: 'invoice_create')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $settings = UsersData::query()
            ->select()
            ->where('user_id',$this->getUser()->getId())
            ->get()
            ->toArray();

        return $this->render('Invoice/generate.html.twig',['settings' => array_merge(...$settings)]);
    }
}


