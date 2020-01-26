<?php

namespace AltezzaTravelBundle\Form\Tour\Type;

use AltezzaTravelBundle\Entity\HotelRoom;
use AltezzaTravelBundle\Entity\TypeRoom;
use AltezzaTravelBundle\Form\Tour\Traits\HotelRoomEntryTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class HotelRoomEntryType extends CollectionType
{
    use HotelRoomEntryTrait;

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $roomTypes = $this->em->getRepository(TypeRoom::class)->findAllSorted();

        $builder
            ->add('roomType', HotelRoomTypeChoiceType::class, [
                'label' => 'Accommodation Type',
                'required' => true,
                'choices_as_values' => true,
                'expanded' => false,
                'choices' => $roomTypes,
                'choice_value' => 'type',
                'choice_label' => 'name',
                'choice_attr' => function ($choiceValue, $key, $value) use ($builder) {
                    $prototypeField = $this->generateChoicePrototype($builder, $choiceValue);

                    return [
                        'data-room-type-prototype' => $prototypeField->getForm()->createView(),
                    ];
                },
                'placeholder' => false,
                'attr' => [
                    'data-behaviour' => 'select-room-type',
                ]
            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($builder, $roomTypes) {
                $form = $event->getForm();

                $this->modifyHotelRoomEntryForm($form, reset($roomTypes));
            })
            ->get('roomType')->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use ($builder) {
                $roomTypeForm = $event->getForm();
                $roomType = $roomTypeForm->getData();
                $form = $roomTypeForm->getParent();

                $this->modifyHotelRoomEntryForm($form, $roomType);
            })
        ;
    }
}
