<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\TextAlign;
use Vich\UploaderBundle\Form\Type\VichImageType;

/**
 * Product crud
 */
class ProductCrudController extends AbstractCrudController
{
    /**
     * Get entity fqcn
     *
     * @return string
     */
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    /**
     * Configure fields
     *
     * @param string $pageName
     *
     * @return iterable
     */
    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('user')
                ->setSortable(false),
            AssociationField::new('category')
                ->setSortable(false),
            ChoiceField::new('status')
                ->setChoices(array_flip(Product::getAllStatuses())),
            TextField::new('name')
                ->setFormTypeOptions([
                    'attr' => [
                        'maxlength' => 128
                    ]
                ]),
            TextAreaField::new('shortDescription')
                ->hideOnIndex()
                ->setFormTypeOptions([
                    'attr' => [
                        'maxlength' => 512
                    ]
                ]),
            MoneyField::new('fakePrice')
                ->setLabel('Price')
                ->setCurrencyPropertyPath('currency')
                ->setTextAlign(TextAlign::LEFT)
                ->setSortable(false)
                ->setFormTypeOptions([
                    'attr' => [
                        'class' => 'input-mask',
                        'maxlength' => 10,
                        'data-inputmask' =>
                            "'alias': 'decimal',
                            'rightAlign': false,
                            'digits': " . 2 . ",
                            'allowMinus': false"
                    ],
                    'required' => true
                ]),
            TextField::new('phone')
                ->setLabel('Contact number')
                ->setSortable(false)
                ->setFormTypeOptions([
                    'attr' => [
                        'class' => 'input-mask',
                        'data-inputmask' => "'mask': '999-999-9999', 'clearIncomplete': true"
                    ]
                ]),
            TextareaField::new('imageFile')
                ->setLabel('Image')
                ->setFormType(VichImageType::class)
                ->hideOnIndex(),
            ImageField::new('imageFilename')
                ->setLabel('Image')
                ->setBasePath('/uploads/products_images')
                ->onlyOnIndex()
                ->setSortable(false)
        ];
    }

    /**
     * Configure assets
     *
     * @param Assets $assets
     *
     * @return Assets
     */
    public function configureAssets(Assets $assets): Assets
    {
        return $assets
            ->addWebpackEncoreEntry('admin_app');
    }
}
