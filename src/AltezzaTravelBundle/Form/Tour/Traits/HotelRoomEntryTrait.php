<?php

namespace AltezzaTravelBundle\Form\Tour\Traits;

use AltezzaTravelBundle\Entity\TypeAccommodation;
use AltezzaTravelBundle\Entity\TypeRoom;
use AltezzaTravelBundle\Repository\TypeAccommodationRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Trait HotelRoomEntryTrait
 * @package AltezzaTravelBundle\Form\Tour\Traits
 */
trait HotelRoomEntryTrait
{
    /**
     * @param FormInterface $form
     * @param TypeRoom      $roomType
     */
    public function modifyHotelRoomEntryForm(
        FormInterface $form,
        TypeRoom $roomType
    ) {
        $form->add(
            'accommodations',
            EntityType::class,
            $this->getAccommodationFieldOptions($roomType)
        );
    }

    /**
     * @param FormBuilderInterface $builder
     * @param TypeRoom             $roomType
     * @return FormBuilderInterface
     */
    public function generateChoicePrototype(FormBuilderInterface $builder, TypeRoom $roomType)
    {
        $prototype = $builder->create(
            'accommodations',
            EntityType::class,
            $this->getAccommodationFieldOptions($roomType, false)
        );

        return $prototype;
    }

    /**
     * @param TypeRoom $roomType
     * @param bool     $csrf
     * @return array
     */
    protected function getAccommodationFieldOptions(TypeRoom $roomType, $csrf = true)
    {
        $options = [
            'class' => TypeAccommodation::class,
            'query_builder' => function (TypeAccommodationRepository $er) use ($roomType) {
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
            'error_bubbling' => false,
            'constraints' => [
                new Assert\Callback(function ($accommodations, ExecutionContextInterface $context) {
                    if (!count($accommodations)) {
                        $context->addViolation('Please choose accommodation type');
                    }
                }),
            ],
        ];

        if (!$csrf) {
            $options['csrf_protection'] = false;
        }

        return $options;
    }
}
