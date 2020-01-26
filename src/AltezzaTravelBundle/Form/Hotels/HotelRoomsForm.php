<?php

namespace AltezzaTravelBundle\Form\Hotels;

use AltezzaTravelBundle\Entity\Hotel;
use AltezzaTravelBundle\Entity\HotelRoom;
use AltezzaTravelBundle\Entity\TypeRoom;
use AltezzaTravelBundle\Form\Hotels\Type\HotelRoomCollectionType;
use AltezzaTravelBundle\Form\Hotels\Type\HotelRoomType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HotelRoomsForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Hotel $hotel */
        $hotel = $builder->getData();
        /** @var TypeRoom[] $roomTypes */
        $roomTypes = $options['room_types'];

        foreach ($roomTypes as $roomTypeSlug => $roomType) {
            $hotelRooms = $hotel->getRoomsByType($roomType);

            $builder->add($roomTypeSlug, HotelRoomCollectionType::class, [
                'label' => false,
                'room_type' => $roomType,
                'entry_type' => HotelRoomType::class,
                'entry_options' => [
                    'data_class' => HotelRoom::class,
                    'hotel' => $hotel,
                    'room_type' => $roomType,
                ],
                'data' => $hotelRooms,
                'by_reference' => true,
                'mapped' => true,
                'property_path' => 'rooms',
                'allow_add' => true,
                'allow_delete' => true,
            ]);
        }

        $builder
            ->add('submit', SubmitType::class, [
                'label' => 'Update',
                'attr' => [
                    'class' => 'admin-btn pull-right show-load-btn',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Hotel::class,
            'room_types' => [],
        ]);
    }

}
