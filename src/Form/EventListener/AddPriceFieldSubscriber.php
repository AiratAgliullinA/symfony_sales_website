<?php

namespace App\Form\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * Add price field for form
 */
class AddPriceFieldSubscriber implements EventSubscriberInterface
{
    /**
     * Return subscribed events
     *
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [FormEvents::PRE_SET_DATA => 'preSetData'];
    }

    /**
     * Preset data for form
     *
     * @param FormEvent $event
     *
     * @return void
     */
    public function preSetData(FormEvent $event): void
    {
        $currency = $event->getData()->getCurrency();
        $form = $event->getForm();

        $form->add('fakePrice', MoneyType::class,
            [
                'label' => 'Price',
                'currency' => $currency,
                'required' => true,
                'divisor' => 100,
                'attr' => [
                    'class' => 'input-mask',
                    'maxlength' => 10,
                    'data-inputmask' =>
                        "'alias': 'decimal',
                        'rightAlign': false,
                        'digits': " . 2 . ",
                        'allowMinus': false"
                ]
            ]
        );
    }
}