<?php

namespace App\Controller;

use App\Form\ProductsFormType;
use App\Model\Products;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductsController extends AbstractController
{

    /**
     * @Route("/products/create", name="create_product")
     */
    public function create(Request $request, ValidatorInterface $validator): Response
    {
        $products = new Products();
        $form = $this->createForm(ProductsFormType::class, $products);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $request->request->all()['products_form'];
            $products = new Products();
            $products->NAME = $formData['NAME'];
            $products->NET_PRICE = (float)$formData['NET_PRICE'];
            $products->TAX_RATE = $formData['TAX_RATE'];
            $products->User_ID = $this->getuser()->getId();
            $products->save();
            $this->addFlash('success', 'Product has been created');
            return new Response($this->redirectToRoute('show_products'));
        }


        $errors = [];

        foreach ($validator->validate($form) as $error) {
            $fieldName = substr($error->getPropertyPath(), 5);
            $errors[] = [$fieldName => $error->getMessage()];
        }

        $errors = array_merge(...$errors);

        return new Response($this->render('/products/create.html.twig', [
            'products_form' => $form->createView(),
            'errors' => $errors,
        ]));
    }

    /**
     * @Route("/products/show", name="show_products")
     */
    public function show(): Response
    {
        if ($this->getUser() === null) {
            return $this->render('security/login.html.twig');
        }

        $productsUserData = Products::query()
            ->where('USER_ID', $this->getUser()->getId())
            ->get()
            ->toArray();

        if (empty($productsUserData)) {
            return new Response($this->render('/products/show.html.twig', [
                'msgEmptyList' => 'You do not have any products. You can add them&nbsp;',
                'msgLink' => $this->generateUrl('create_product'),
            ]));
        }

        return new Response($this->render('/products/show.html.twig', [
            'productsData' => $productsUserData,
        ]));
    }

    /**
     * @Route("/products/update/id={id}", name="update_product")
     */
    public function update(int $id, Request $request, ValidatorInterface $validator): Response
    {
        $editedProductsData = Products::query()
            ->where('ID', $id)
            ->where('USER_ID', $this->getUser()->getId())
            ->select('NAME', 'NET_PRICE', 'TAX_RATE')
            ->first();

        if (empty($editedProductsData)) {
            $this->addFlash('error', 'You are not allowed to edit these product');
            return new Response($this->redirectToRoute('show_products'));
        }

        $productDataToCompare = clone $editedProductsData;

        $form = $this->createForm(ProductsFormType::class, $editedProductsData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $request->request->all()['products_form'];
            $formDataKeysNotToEdit = ['Create', '_token'];
            $formDataToCheck = array_diff_key($formData, array_flip($formDataKeysNotToEdit));
            $fieldsToUpdate = array_diff_assoc($formDataToCheck, $productDataToCompare->toArray());
            if (empty($fieldsToUpdate)) {
                $this->addFlash('error', 'There is nothing to change');
                return new Response($this->redirectToRoute('show_products'));
            }

            Products::query()
                ->where('ID', $id)
                ->where('USER_ID', $this->getUser()->getId())
                ->update($fieldsToUpdate);

            $this->addFlash('success', 'Product data updated');
            return new Response($this->redirectToRoute('show_products'));
        }

        $errors = [];

        foreach ($validator->validate($form) as $error) {
            $fieldName = substr($error->getPropertyPath(), 5);
            $errors[] = [$fieldName => $error->getMessage()];
        }

        $errors = array_merge(...$errors);

        return new Response($this->render('/products/edit.html.twig', [
            'productData' => $editedProductsData,
            'products_form' => $form->createView(),
            'errors' => $errors,
        ]));
    }

    /**
     * @Route("/products/delete/id={id}", name="delete_product")
     */
    public function delete($id): Response
    {
        $editedProductData = Products::query()
            ->where('ID', $id)
            ->where('USER_ID', $this->getUser()->getId())
            ->first();

        if (empty($editedProductData)) {
            $this->addFlash('error', 'You are not allowed to delete these product');
            return new Response($this->redirectToRoute('show_products'));
        }

        Products::query()
            ->where('ID', $id)
            ->where('USER_ID', $this->getUser()->getId())
            ->delete();

        $this->addFlash('success', 'Product has been deleted');
        return new Response($this->redirectToRoute('show_products'));
    }

}
