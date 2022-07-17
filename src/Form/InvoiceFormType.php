<?php


namespace App\Form;

use App\Model\Invoices;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class InvoiceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->setMethod('POST')
            ->add('USER_NIP', TextType::class)
            ->add('USER_NAME', TextType::class)
            ->add('USER_STREET', TextType::class)
            ->add('USER_ZIP_CODE', TextType::class)
            ->add('USER_CITY', TextType::class)
            ->add('USER_CITY', TextType::class)
            ->add('USER_EMAIL', TextType::class)
            ->add('CLIENT_NIP', TextType::class)
            ->add('CLIENT_NAME', TextType::class)
            ->add('CLIENT_STREET', TextType::class)
            ->add('CLIENT_ZIP_CODE', TextType::class)
            ->add('CLIENT_CITY', TextType::class)
            ->add('CLIENT_EMAIL', TextType::class)
            ->add('DATE_OF_ISSUE', TextType::class,['empty_data' =>date('Y/m/d')])
            ->add('PAY_BY', TextType::class)
            ->add('REALISED_ON', TextType::class)
            ->add('TAX_RATE', TextType::class)
            ->add('NET_PRICE', TextType::class)
            ->add('GROSS_UNIT_PRICE', TextType::class)
            ->add('PRODUCT_NAME', TextType::class)
            ->add('QUANTITY', TextType::class)
            ->add('TOTAL_GROSS_PRICE', MoneyType::class)
            ->add('Submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Invoices::class,
            'error_mapping' => []
        ]);
    }
}