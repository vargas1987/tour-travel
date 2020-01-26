<?php

namespace AltezzaTravelBundle\Form\Hotels;

use AltezzaTravelBundle\Entity\Hotel;
use AltezzaTravelBundle\Entity\HotelSeasonType;
use AltezzaTravelBundle\Form\Hotels\Type\HotelSeasonTypeEntryType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class HotelSeasonTypeForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Hotel $data */
        $data = $builder->getData();

        $builder
            ->add('hotelSeasonTypes', CollectionType::class, [
                'entry_type' => HotelSeasonTypeEntryType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'constraints' => [
                    new Assert\Callback(function ($hotelSeasonTypes, ExecutionContextInterface $context) {
//                        /** @var HotelSeasonType $hotelSeasonType */
//                        foreach ($hotelSeasonTypes as $hotelSeasonType) {
//                            /** @var HotelSeasonType $intersectHotelSeasonType */
//                            foreach ($hotelSeasonTypes as $intersectHotelSeasonType) {
//                                if ($hotelSeasonType->getSeasonType()->getTitle() === $intersectHotelSeasonType->getSeasonType()->getTitle()) {
//                                    $context->addViolation('Crosses of season types are detected');
//                                }
//                            }
//                        }
                    }),
                ],
            ])
        ;

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use ($data) {
            $form = $event->getForm();
            /** @var HotelSeasonType[] $hotelSeasonTypes */
            $hotelSeasonTypes = $form->get('hotelSeasonTypes')->getData();

            foreach ($hotelSeasonTypes as $hotelSeasonType) {
                if (!$hotelSeasonType->getHotel()) {
                    $hotelSeasonType->setHotel($data);
                }
            }
        });
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => Hotel::class,
            ])
        ;
    }
}