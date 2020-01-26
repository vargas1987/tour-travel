<?php

namespace AltezzaTravelBundle\Form\Hotels;

use AltezzaTravelBundle\Entity\Hotel;
use AltezzaTravelBundle\Entity\HotelChain;
use AltezzaTravelBundle\Entity\HotelMobileCamp;
use AltezzaTravelBundle\Entity\TerritorialAirstrip;
use AltezzaTravelBundle\Entity\TerritorialArea;
use AltezzaTravelBundle\Entity\TerritorialLocation;
use AltezzaTravelBundle\Entity\TypeHotel;
use AltezzaTravelBundle\Entity\TypeMealPlan;
use AltezzaTravelBundle\Form\Hotels\Type\HotelContactType;
use AltezzaTravelBundle\Form\Hotels\Type\MobileCampType;
use AltezzaTravelBundle\Repository\HotelChainRepository;
use AltezzaTravelBundle\Repository\TypeHotelRepository;
use AltezzaTravelBundle\Repository\TypeMealPlanRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class HotelForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entity = $builder->getForm()->getData();

        $builder
            ->add('status', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'On' => Hotel::STATUS_ENABLED,
                    'Off' => Hotel::STATUS_DISABLED,
                ],
                'expanded' => true,
                'multiple' => false,
                'required' => true,
            ])
            ->add('ratio', HiddenType::class, [
                'empty_data' => 0,
            ])
            ->add('title', TextType::class, [
                'label' => 'Hotel Name',
                'required' => true,
                'attr' => [
                    'class' =>'text',
                ],
            ])
            ->add('chain', EntityType::class, [
                'class' => HotelChain::class,
                'query_builder' => function(HotelChainRepository $er) {
                    return $er->getAllSortedQB();
                },
                'choice_label' => 'title',
                'label' => 'Hotel Chain',
                'required' => false,
                'placeholder' => '---',
            ])
            ->add('type', EntityType::class, [
                'class' => TypeHotel::class,
                'query_builder' => function(TypeHotelRepository $er) {
                    return $er->getAllSortedQB();
                },
                'choice_label' => 'title',
                'label' => 'Hotel type',
                'required' => false,
                'placeholder' => '---',
            ])
            ->add('mealPlans', EntityType::class, [
                'class' => TypeMealPlan::class,
                'query_builder' => function(TypeMealPlanRepository $er) {
                    return $er->getAllSortedQB();
                },
                'constraints' => [
                    new Assert\Callback(function ($mealPlans, ExecutionContextInterface $context) {
                        /** @var TypeMealPlan[]|ArrayCollection $mealPlans */
                        if (!$mealPlans->count()) {
                            $context->addViolation('Enter at least one meal plan');
                        }
                    }),
                ],
                'choice_label' => 'title',
                'choice_value' => 'type',
                'label' => 'Meal Plan Type',
                'error_bubbling' => true,
                'required' => true,
                'expanded' => true,
                'multiple' => true,
                'placeholder' => false,
            ])
            ->add('location', EntityType::class, [
                'label' => 'Location',
                'class' => TerritorialLocation::class,
                'choice_label' => 'title',
                'mapped' => true,
                'by_reference' => true,
                'required' => true,
                'placeholder' => false,
            ])
            ->add('area', EntityType::class, [
                'label' => 'Area',
                'class' => TerritorialArea::class,
                'choice_label' => 'title',
                'mapped' => true,
                'by_reference' => true,
                'disabled' => $entity->isMobileCamp(),
                'required' => true,
                'placeholder' => false,
            ])
            ->add('airstrip', EntityType::class, [
                'label' => 'Closest airport / airstrip',
                'class' => TerritorialAirstrip::class,
                'choice_label' => 'title',
                'mapped' => true,
                'by_reference' => true,
                'disabled' => $entity->isMobileCamp(),
                'required' => true,
                'placeholder' => false,
            ])
            ->add('timeToAirstrip', NumberType::class, [
                'label' => 'Transfer Time (min)',
                'required' => true,
                'attr' => [
                    'class' =>'text',
                ],
                'disabled' => $entity->isMobileCamp(),
                'constraints' => [
                    new Assert\Range([
                        'min' => 1,
                    ]),
                ],
            ])
            ->add('isMobileCamp', CheckboxType::class, [
                'label' => 'Mobile Camp',
                'required' => false,
            ])
            ->add('mobileCamps', CollectionType::class, [
                'entry_type' => MobileCampType::class,
                'prototype_data' => new HotelMobileCamp(),
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'constraints' => [
                    new Assert\Callback(function ($mobileCamps, ExecutionContextInterface $context) {
                        /** @var HotelMobileCamp[] $mobileCamps */
                        foreach ($mobileCamps as $mobileCamp) {
                            if ($mobileCamp->getDateFrom() >= $mobileCamp->getDateTo()) {
                                $context->addViolation('The start date of the mobile camp can not be greater than or equal to the end date');
                            }

                            foreach ($mobileCamps as $intersectMobileCamp) {
                                if ($mobileCamp !== $intersectMobileCamp
                                    && (
                                        ($mobileCamp->getDateFrom() >= $intersectMobileCamp->getDateFrom()
                                            && $mobileCamp->getDateFrom() <= $intersectMobileCamp->getDateTo()
                                        ) || ($mobileCamp->getDateTo() >= $intersectMobileCamp->getDateFrom()
                                            && $mobileCamp->getDateTo() <= $intersectMobileCamp->getDateTo()
                                        )
                                    )
                                ) {
                                    $context->addViolation('Crosses of mobile camps periods are detected');
                                }
                            }
                        }
                    }),
                ],
            ])
            ->add('childTo', NumberType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' =>'text',
                ],
            ])
            ->add('teenagerFrom', NumberType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' =>'text',
                ],
            ])
            ->add('teenagerTo', NumberType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' =>'text',
                ],
            ])
            ->add('adultFrom', NumberType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' =>'text',
                ],
            ])
            ->add('note', TextareaType::class, [
                'label' => 'Notes',
                'required' => false,
                'attr' => [
                    'class' =>'text',
                    'rows' => 4,
                ]
            ])
            ->add('concessionFeesIncl', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'Concession fees incl' => true,
                    'No Concession fees' => false,
                ],
                'expanded' => true,
                'multiple' => false,
                'required' => true,
            ])
            ->add('wmaIncl', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'WMA incl' => true,
                    'No WMA' => false,
                ],
                'expanded' => true,
                'multiple' => false,
                'required' => true,
            ])
            ->add('booking', TextType::class, [
                'label' => 'Booking',
                'data' => $entity->getExtraData('booking', 'url'),
                'mapped' => false,
                'required' => false,
            ])
            ->add('tripadvisor', TextType::class, [
                'label' => 'Tripadvisor',
                'data' => $entity->getExtraData('tripadvisor', 'url'),
                'mapped' => false,
                'required' => false,
            ])
            ->add('contacts', CollectionType::class, [
                'entry_type' => HotelContactType::class,
                'mapped' => true,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => !$entity->getId() ? 'Add hotel' : 'Update',
                'attr' => [
                    'class' => 'admin-btn pull-right show-load-btn',
                ],
            ])
        ;

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();
            /** @var Hotel $hotel */
            $hotel = $form->getData();

            $currentBookingUrl = $hotel->getExtraData('booking', 'url');
            $bookingUrl = $form->get('booking')->getData();
            if ($bookingUrl !== $currentBookingUrl) {
                $bookingRateData = [
                    'url' => $bookingUrl,
                    'rate' => null,
                ];

                $hotel->addExtraData('booking', $bookingRateData);
            }

            $currentTripadvisorUrl = $hotel->getExtraData('tripadvisor', 'url');
            $tripadvisorUrl = $form->get('tripadvisor')->getData();
            if ($tripadvisorUrl !== $currentTripadvisorUrl) {
                $tripadvisorRateData = [
                    'url' => $tripadvisorUrl,
                    'rate' => null,
                ];

                $hotel->addExtraData('tripadvisor', $tripadvisorRateData);
            }

            foreach ($hotel->getMobileCamps() as $mobileCamp) {
                $mobileCamp->setLocation($hotel->getLocation());
            }

            if (($hotel->getChildTo() && (
                    ($hotel->getTeenagerFrom() && (int) $hotel->getChildTo() >= (int) $hotel->getTeenagerFrom())
                    || ($hotel->getTeenagerTo() && (int) $hotel->getChildTo() >= (int) $hotel->getTeenagerTo())
                    || ($hotel->getAdultFrom() && (int) $hotel->getChildTo() >= (int) $hotel->getAdultFrom())
                )) || ($hotel->getTeenagerFrom() && (
                    ($hotel->getChildTo() && (int) $hotel->getTeenagerFrom() <= (int) $hotel->getChildTo())
                    || ($hotel->getTeenagerTo() && (int) $hotel->getTeenagerFrom() >= (int) $hotel->getTeenagerTo())
                    || ($hotel->getAdultFrom() && (int) $hotel->getTeenagerFrom() >= (int) $hotel->getAdultFrom())
                )) || ($hotel->getTeenagerTo() && (
                    ($hotel->getChildTo() && (int) $hotel->getTeenagerTo() <= (int) $hotel->getChildTo())
                    || ($hotel->getTeenagerFrom() && (int) $hotel->getTeenagerTo() <= (int) $hotel->getTeenagerFrom())
                    || ($hotel->getAdultFrom() && (int) $hotel->getTeenagerTo() >= (int) $hotel->getAdultFrom())
                )) || ($hotel->getAdultFrom() && (
                    ($hotel->getChildTo() && (int) $hotel->getAdultFrom() <= (int) $hotel->getChildTo())
                    || ($hotel->getTeenagerFrom() && (int) $hotel->getAdultFrom() <= (int) $hotel->getTeenagerFrom())
                    || ($hotel->getTeenagerTo() && (int) $hotel->getAdultFrom() <= (int) $hotel->getTeenagerTo())
                ))
            ) {
                $form->addError(new FormError('Crossing into ages'));
            }
        });

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Hotel::class,
            'constraints' => [
                new UniqueEntity(['fields' => ['title'], 'message' => 'Hotel with this name already exists']),
            ],
        ]);
    }
}
