<?php

namespace AltezzaTravelBundle\Form\Hotels\Traits;

use AltezzaTravelBundle\Entity\HotelRoom;
use AltezzaTravelBundle\Entity\TypeAccommodation;
use AltezzaTravelBundle\Entity\TypeRoom;
use AltezzaTravelBundle\Repository\TypeAccommodationRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Trait HotelRoomEntryTrait
 * @package AltezzaTravelBundle\Form\Tour\Traits
 */
trait HotelPriceSpecificRoomEntryTrait
{
    /**
     * @param FormBuilderInterface $builder
     * @param FormInterface        $form
     * @param HotelRoom            $room
     */
    public function modifyHotelRoomEntryForm(
        FormBuilderInterface $builder,
        FormInterface $form,
        HotelRoom $room
    ) {
        $form->add(
            'accommodationType',
            EntityType::class,
            $this->getAccommodationFieldOptions($room)
        );
    }

    /**
     * @param FormBuilderInterface $builder
     * @param HotelRoom            $room
     * @return FormBuilderInterface
     */
    public function generateChoicePrototype(FormBuilderInterface $builder, HotelRoom $room)
    {
        $prototype = $builder->create(
            'accommodationType',
            EntityType::class,
            $this->getAccommodationFieldOptions($room, false)
        );

        return $prototype;
    }

    /**
     * @param HotelRoom $room
     * @param bool     $csrf
     * @return array
     */
    protected function getAccommodationFieldOptions(HotelRoom $room, $csrf = true)
    {
        $options = [
            'class' => TypeAccommodation::class,
            'query_builder' => function (TypeAccommodationRepository $er) use ($room) {
                return $er->getAvailableAccommodationByRoomQB($room);
            },
            'choice_label' => 'type',
            'choice_attr' => function (TypeAccommodation $entity = null) {
                return [
                    'adult' => $entity->getCountAdult(),
                    'teenager' => $entity->getCountTeenager(),
                    'child' => $entity->getCountChild(),
                    'data-class' => 'asdasdasd',
                ];
            },
            'attr' => [
                'class' => 'dropdown-accommodation',
            ],
            'label' => false,
            'mapped' => true,
            'required' => true,
            'expanded' => false,
            'multiple' => false,
            'placeholder' => false,
        ];

        if (!$csrf) {
            $options['csrf_protection'] = false;
        }

        return $options;
    }
}
