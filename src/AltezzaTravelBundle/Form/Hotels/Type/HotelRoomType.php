<?php

namespace AltezzaTravelBundle\Form\Hotels\Type;

use AltezzaTravelBundle\Entity\Hotel;
use AltezzaTravelBundle\Entity\HotelRoom;
use AltezzaTravelBundle\Entity\TypeAccommodation;
use AltezzaTravelBundle\Entity\TypeRoom;
use AltezzaTravelBundle\Repository\TypeAccommodationRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class HotelRoomAccommodationType
 * @package AltezzaTravelBundle\Form\Hotels\Type
 */
class HotelRoomType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Hotel $hotel */
        $hotel = $options['hotel'];
        /** @var TypeRoom $roomType */
        $roomType = $options['room_type'];

        /** @var HotelRoom|null $hotelRoom */
        $hotelRoom = $builder->getData();
        if (null !== $hotelRoom) {
            $hotelRoom->setHotel($hotel);
            $hotelRoom->setRoomType($roomType);
        }

        $builder
            ->add('title', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' =>'text',
                    'tabindex' => 1,
                ],
            ])
            ->add('accommodations', EntityType::class, [
                'class' => TypeAccommodation::class,
                'query_builder' => function(TypeAccommodationRepository $er) use ($roomType) {
                    return $er->getAvailableAccommodationByRoomTypeQB($roomType);
                },
                'choice_label' => 'type',
                'choice_attr' => function (TypeAccommodation $entity = null) {
                    return [
                        'adult' => $entity->getCountAdult(),
                        'teenager' => $entity->getCountTeenager(),
                        'child' => $entity->getCountChild(),
                    ];
                },
                'label' => false,
                'required' => true,
                'expanded' => true,
                'multiple' => true,
                'placeholder' => false,
            ])
        ;

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use ($hotel, $roomType) {
            /** @var HotelRoom $hotelRoom */
            $hotelRoom = $event->getData();
            $hotelRoom->setRoomType($roomType);

            if ($hotelRoom->getAccommodations()->isEmpty()) {
                $event->getForm()->addError(new FormError('Accommodation can not be empty'));
            }
        });
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setRequired('hotel')
            ->setRequired('room_type')
            ->setAllowedTypes('hotel', Hotel::class)
            ->setAllowedTypes('room_type', TypeRoom::class)
            ->setDefaults([
                'data_class' => HotelRoom::class,
            ])
        ;
    }
}
