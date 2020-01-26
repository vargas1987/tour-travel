<?php

namespace AltezzaTravelBundle\Form\Hotels;

use AltezzaTravelBundle\Entity\Hotel;
use AltezzaTravelBundle\Entity\HotelPriceAdditionalFee;
use AltezzaTravelBundle\Entity\HotelPriceSupplement;
use AltezzaTravelBundle\Entity\HotelYearsOptions;
use AltezzaTravelBundle\Form\Hotels\Type\HotelPriceAdditionalFeeType;
use AltezzaTravelBundle\Form\Hotels\Type\HotelPriceAdditionalPersonType;
use AltezzaTravelBundle\Form\Hotels\Type\HotelPriceMealPlanPersonType;
use AltezzaTravelBundle\Form\Hotels\Type\HotelPriceSupplementType;
use AltezzaTravelBundle\Form\Hotels\Type\HotelPriceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Class HotelPricesForm
 * @package AltezzaTravelBundle\Form\Hotels
 */
class HotelPricesForm extends AbstractType
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
        $yearsList = $data->getYearsList(true, true, 1);

        $builder
            ->add('year', ChoiceType::class, [
                'placeholder' => false,
                'data' => $currentYear,
                'choices' => array_combine($yearsList, $yearsList),
                'required' => true,
                'mapped' => false,
                'by_reference' => false,
            ]);

        $builder->add('hotelPriceAdditionalPerson', HotelPriceAdditionalPersonType::class, [
            'data' => $data,
            'year' => $currentYear,
            'mapped' => false,
            'by_reference' => false,
        ]);

        $builder->add('hotelPriceMealPlanPerson', HotelPriceMealPlanPersonType::class, [
            'label' => 'MEAL PLANS ($)',
            'data' => $data,
            'year' => $currentYear,
            'mapped' => false,
            'by_reference' => false,
        ]);

        $builder->add('priceAdditionalFees', CollectionType::class, [
            'entry_type' => HotelPriceAdditionalFeeType::class,
            'by_reference' => false,
            'mapped' => true,
            'allow_add' => true,
            'allow_delete' => true,
        ]);

        $builder->add('priceSupplements', CollectionType::class, [
            'entry_type' => HotelPriceSupplementType::class,
            'by_reference' => false,
            'mapped' => true,
            'allow_add' => true,
            'allow_delete' => true,
            'constraints' => [
                new Assert\Callback(function ($priceSupplements, ExecutionContextInterface $context) use ($currentYear) {
                    /** @var HotelPriceSupplement[] $priceSupplements */
                    foreach ($priceSupplements as $priceSupplement) {
                        if ($priceSupplement->getDateFrom() > $priceSupplement->getDateTo()) {
                            $context->addViolation('The start date of the supplement can not be greater than or equal to the end date');
                        }

                        if ($priceSupplement->getYear() !== $currentYear) {
                            $context->addViolation('Supplement do not coincide with the selected year');
                        }
                        foreach ($priceSupplements as $intersectPriceSupplement) {
                            if ($priceSupplement !== $intersectPriceSupplement
                                && $priceSupplement->getType() === $intersectPriceSupplement->getType()
                                && (
                                    ($priceSupplement->getDateFrom() >= $intersectPriceSupplement->getDateFrom()
                                        && $priceSupplement->getDateFrom() <= $intersectPriceSupplement->getDateTo()
                                    ) || ($priceSupplement->getDateTo() >= $intersectPriceSupplement->getDateFrom()
                                        && $priceSupplement->getDateTo() <= $intersectPriceSupplement->getDateTo()
                                    )
                                )
                            ) {
                                $context->addViolation('Crosses of supplement periods are detected');

                                return;
                            }
                        }
                    }
                }),
            ],
        ]);


        $roomSlugs = array_reduce(
            $data->getRoomSlugs(false, true, true)->toArray(),
            function ($result, $item) {
                $result[$item['slug']] = $item['title'];

                return $result;
            },
            []
        );

        $builder
            ->add('roomSlugs', ChoiceType::class, [
                'label' => 'Filter rooms',
                'placeholder' => 'All',
                'choices' => array_flip($roomSlugs),
                'mapped' => false,
                'by_reference' => false,
                'required' => false,
            ])
            ->add('prices', HotelPriceType::class, [
                'data' => $data,
                'year' => $currentYear,
                'mapped' => false,
                'by_reference' => false,
            ])
            ->add('recalculate', CheckboxType::class, [
                'label' => 'Calculate prices on update',
                'mapped' => false,
                'data' => $data->getYearOption($currentYear, HotelYearsOptions::RECALCULATE_RATES_ON_SUBMIT, true),
                'required' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Update',
                'attr' => [
                    'class' => 'admin-btn pull-right show-load-btn',
                ],
            ])
        ;

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use (
            $data,
            $currentYear
        ) {
            $priceAdditionalFees = $event->getForm()->get('priceAdditionalFees')->getData();
            /** @var HotelPriceAdditionalFee $priceAdditionalFee */
            foreach ($priceAdditionalFees as $priceAdditionalFee) {
                $priceAdditionalFee->setHotel($data);
                $priceAdditionalFee->setYear($currentYear);
            }

            $data->setYearOption(
                $currentYear,
                HotelYearsOptions::RECALCULATE_RATES_ON_SUBMIT,
                HotelYearsOptions::OPTION_TYPE_BOOLEAN,
                $event->getForm()->get('recalculate')->getData()
            );
        });
    }

    /**
     * @param FormView      $view
     * @param FormInterface $form
     * @param array         $options
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['current_year'] = $options['year'];
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
            ->setRequired('year')
        ;
    }
}
