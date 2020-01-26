<?php

namespace AltezzaTravelBundle\Form\Hotels\Type;

use AltezzaTravelBundle\Entity\Hotel;
use AltezzaTravelBundle\Entity\HotelPrice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class HotelPriceType
 * @package AltezzaTravelBundle\Form\Hotels\Type
 */
class HotelPriceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Hotel $data */
        $data = $builder->getData();
        $currentYear = (int) $options['year'];

        $optionNames = [];

        foreach ($data->getPrices($currentYear) as $hotelPrice) {
            $slug = sprintf('%s-%s-%s-%s-%s',
                $hotelPrice->getHotel()->getId(),
                $hotelPrice->getRoom()->getId(),
                $hotelPrice->getMealPlanType()->getType(),
                $hotelPrice->getAccommodationType()->getType(),
                $hotelPrice->getSeasonType()->getType()
            );

            $optionNames[] = [
                'name' => $slug,
                'data' => $hotelPrice,
            ];

            $builder
                ->add($slug, NumberType::class, [
                    'mapped' => false,
                    'by_reference' => false,
                    'data' => $hotelPrice->getPrice(),
                    'attr' => [
                        'class' =>'text',
                    ],
                ])
            ;
        }

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use ($data, $currentYear, $optionNames) {
            foreach ($optionNames as $optionName) {
                /** @var HotelPrice $optionObject */
                $optionObject = $optionName['data'];
                $optionValue = $event->getForm()->get($optionName['name'])->getData();

                $optionObject->setPrice($optionValue);
            }
        });
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefault('data_class', Hotel::class)
            ->setRequired('year')
        ;
    }
}
