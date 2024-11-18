<?php

namespace App\Form;

use App\Entity\StockItem;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\PositiveOrZero;

class StockItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Name field shall not be blank.'])
                ],
                'attr' => ['class' => 'form-control']
                
            ])
            ->add('quantity', IntegerType::class, [
                'label' => 'Quantity',
                'constraints' => [
                    new NotBlank(['message' => 'Quantity is required.']),
                    new PositiveOrZero(['message' => 'Quantity must be a positive number or zero.'])
                ],

                'attr' => [
                    'class' => 'form-control',
                    'min' => 1
                    ]
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Price',
                'currency' => 'USD',
                'constraints' => [
                    new NotBlank(["message" => 'Price is required.']),
                    new Positive(['message' => 'Price must be a positive number.'])
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'constraints' => [
                    new NotBlank(['message' => 'Enter your text here.'])
                ],
                'attr' =>[
                    'class' => 'form-control',
                    'rows' => 4,
                ]
            ])
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StockItem::class,
        ]);
    }
}
