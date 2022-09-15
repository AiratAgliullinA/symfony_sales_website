<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\TextAlign;

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
            AssociationField::new('user'),
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
                ->setFormTypeOptions([
                    'attr' => [
                        'class' => 'input-mask',
                        'maxlength' => 10,
                        'data-inputmask' =>
                            "'alias': 'decimal',
                            'rightAlign': false,
                            'digits': " . 2 . ",
                            'allowMinus': false"
                    ]
                ]),
            TextField::new('phone')
                ->setLabel('Contact number')
                ->setFormTypeOptions([
                    'attr' => [
                        'class' => 'input-mask',
                        'data-inputmask' => "'mask': '999-999-9999', 'clearIncomplete': true"
                    ]
                ])
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
