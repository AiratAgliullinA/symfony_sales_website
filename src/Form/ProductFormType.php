<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Product;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;

/**
 * Product form
 */
class ProductFormType extends AbstractType
{
    /**
     * Build form
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,
                [
                    'label' => 'Name',
                    'required' => true,
                    'constraints' => [
                        new Length([
                            'max' => 255,
                            'maxMessage' => 'Maximum length {{ limit }} characters'
                        ])
                    ]
                ]
            )
            ->add('shortDescription', TextareaType::class,
                [
                    'label' => 'Short description',
                    'required' => true,
                    'constraints' => [
                        new Length([
                            'max' => 512,
                            'maxMessage' => 'Maximum length {{ limit }} characters'
                        ])
                    ]
                ]
            )
            ->add('image', FileType::class,
                [
                    'label' => 'Image',
                    'mapped' => false,
                    'required' => false,
                    'constraints' => [
                        new File([
                            'maxSize' => '1024k',
                            'mimeTypes' => [
                                'image/jpeg',
                                'image/png',
                                'image/jpg'
                            ],
                            'mimeTypesMessage' => 'Please upload a valid image file'
                        ])
                    ]
                ]
            )
            ->add('isRemoveImage', HiddenType::class)
            ->add('save', SubmitType::class,
                [
                    'label' => 'Save'
                ]
            );
    }

    /**
     * Configure
     *
     * @param OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}