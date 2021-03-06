<?php

namespace AltezzaTravelBundle\Form\Tour;

use AltezzaTravelBundle\Entity\TerritorialArea;
use AltezzaTravelBundle\Entity\TerritorialLocation;
use AltezzaTravelBundle\Entity\TypeMealPlan;
use AltezzaTravelBundle\Form\Tour\Type\HotelRoomCollectionType;
use AltezzaTravelBundle\Form\Tour\Type\HotelRoomEntryType;
use AltezzaTravelBundle\Repository\TypeMealPlanRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class HotelSearchForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $period = $builder->create('period', FormType::class, [
            'label' => 'Dates of accommodations:',
            'error_bubbling' => false,
            'inherit_data' => true,
        ]);

        $period
            ->add('dateFrom', DateType::class, [
                'label' => false,
                'required' => true,
                'html5' => true,
                'widget' => 'single_text',
                'format' => 'd MMM yyyy',
                'placeholder' => false,
                'attr' => [
                    'data-type' => 'date-from',
                    'data-format' => 'd M yy',
                    //'data-mask' => '99/99/9999',
                    'data-placeholder' => 'dd MMM yyyy',
                    'autocomplete' => 'off',
                ],
                'constraints' => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Date(),
                ],
            ])
            ->add('dateTo', DateType::class, [
                'label' => false,
                'required' => true,
                'html5' => true,
                'widget' => 'single_text',
                'format' => 'd MMM yyyy',
                'placeholder' => false,
                'attr' => [
                    'data-type' => 'date-to',
                    'data-format' => 'd M yy',
                    //'data-mask' => '99/99/9999',
                    'data-placeholder' => 'dd MMM yyyy',
                    'autocomplete' => 'off',
                ],
                'constraints' => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Date(),
                ],
            ])
        ;

        $builder
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
                'attr' => [
                    'data-type' => 'area',
                    'mul'
                ],
                'expanded'  => false,
                'multiple'  => true,
                'mapped' => true,
                'by_reference' => true,
                'required' => false,
                'placeholder' => false,
            ])
            ->add('typeMealPlan', EntityType::class, [
                'label' => 'Meal plan',
                'class' => TypeMealPlan::class,
                'query_builder' => function(TypeMealPlanRepository $er) {
                    return $er->getAllSortedQB();
                },
                'choice_label' => 'description',
                'mapped' => true,
                'by_reference' => true,
                'required' => true,
                'placeholder' => false,
            ])
            ->add($period)
            ->add('rooms', HotelRoomCollectionType::class, [
                'label' => false,
                'entry_type' => HotelRoomEntryType::class,
                'mapped' => true,
                'by_reference' => true,
                'allow_add' => true,
                'allow_delete' => true,
                'error_bubbling' => false,
                'constraints' => [
                    new Assert\Callback(function ($rooms, ExecutionContextInterface $context) {
                        if (!count($rooms)) {
                            $context->addViolation('Please choose accommodation type');
                        }

                        foreach ($rooms as $room) {
                            if ($room['accommodations']->isEmpty()) {
                                $context->addViolation('Please choose accommodation type');
                            }
                        }
                    }),
                ],
            ])
            ->add('sorting', ChoiceType::class, [
                'label' => 'Sort:',
                'choices' => [
                    'Price lowest first' => 'asc',
                    'Price highest first' => 'desc',
                ],
                'empty_data' => 'asc',
                'expanded' => false,
                'multiple' => false,
                'mapped' => false,
                'required' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Show all options',
                'attr' => [
                    'class' => 'admin-btn pull-right show-load-btn',
                ],
            ])
        ;


        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();

            $period = $form->get('period');
            $dateFrom = $period->get('dateFrom')->getData();
            $dateTo = $period->get('dateTo')->getData();

            if ($dateFrom >= $dateTo) {
                $period->addError(new FormError('The start date can not be greater than or equal to the end date'));
            }
        });
    }
}
