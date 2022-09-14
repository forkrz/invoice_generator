<?php


namespace App\Form;

use App\Model\InvoicesProducts;
use App\Model\Products;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductsInvoiceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->setMethod('POST')
            ->add('NAME', TextType::class)
            ->add('Quantity', TextType::class)
            ->add('NET_PRICE', TextType::class)
            ->add('TAX_RATE', TextType::class)
            ->add('NET_VALUE', TextType::class)
            ->add('TAX_VALUE', TextType::class)
            ->add('GROSS_VALUE', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InvoicesProducts::class,
            'error_mapping' => []
        ]);
    }
}