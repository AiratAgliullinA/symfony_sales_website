<?php

namespace App\Form\EventListener;

use App\Converter\MoneyConverter;
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
                'currency' => $currency ?: MoneyConverter::MAIN_CURRENCY_ISO,
                'divisor' => 100
            ]
        );
    }
}