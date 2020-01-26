<?php

namespace AltezzaTravelBundle\Form\Hotels\Type;

use AltezzaTravelBundle\Entity\Hotel;
use AltezzaTravelBundle\Entity\HotelYearsOptions;
use AltezzaTravelBundle\Entity\TypeSeason;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class HotelPriceAdditionalPersonType
 * @package AltezzaTravelBundle\Form\Hotels\Type
 */
class HotelPriceAdditionalPersonType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Hotel $data */
        $data = $builder->getData();
        $currentYear = $options['year'];

        $optionNames = [];
        foreach ($data->getRoomSlugs(true, true) as $roomSlug) {
            foreach (HotelYearsOptions::getPriceAdditionalPersonOptions($data->isTeenageRangeInit()) as $optionName => $optionLabel) {
                $optionPrimaryName = sprintf('%s-%s', $roomSlug['slug'], $optionName);

                $optionTypes = [
                    HotelYearsOptions::PRICE_OPTION_VALUE_AMOUNT,
                    HotelYearsOptions::PRICE_OPTION_VALUE_PERCENT,
                ];

                if ($optionName === HotelYearsOptions::PRICE_OPTION_PER_PERSON_RATE) {
                    $optionTypes = [
                        HotelYearsOptions::PRICE_OPTION_VALUE_AMOUNT,
                    ];
                }

                $optionNames[] = [
                    'parent' => $optionName,
                    'type' => HotelYearsOptions::OPTION_TYPE_STRING,
                    'current' => $optionPrimaryName,
                ];

                $optionValue = $data->getYearOption(
                    $currentYear,
                    $optionPrimaryName,
                    HotelYearsOptions::PRICE_OPTION_VALUE_AMOUNT
                );

                $builder->add($optionPrimaryName, ChoiceType::class, [
                    'label' => $optionLabel,
                    'choices' => array_combine($optionTypes, $optionTypes),
                    'choice_attr' => function($choiceValue, $key, $value) use ($optionPrimaryName) {
                        switch ($key) {
                            case HotelYearsOptions::PRICE_OPTION_VALUE_AMOUNT:
                                return [
                                    'data-type-option' => $optionPrimaryName,
                                    'data-price-type' => 'person',
                                    'data-price-value' => '$',
                                    'placeholder' => $value,
                                ];
                            case HotelYearsOptions::PRICE_OPTION_VALUE_PERCENT:
                                return [
                                    'data-type-option' => $optionPrimaryName,
                                    'data-price-type' => 'person',
                                    'data-price-value' => '%',
                                    'placeholder' => $value,
                                ];
                        }
                    },
                    'data' => $optionValue,
                    'block_name' => 'hotelPriceAdditionalPersonRadio',
                    'expanded' => true,
                    'multiple' => false,
                    'mapped' => false,
                    'by_reference' => false,
                    'required' => true,
                    'constraints' => [
                        new Assert\NotNull([
                            'message' => 'Additional fee price should not be null.',
                        ]),
                    ],
                ]);

                if (\in_array($optionName, HotelYearsOptions::INCLUDE_SUPPLEMENT_OPTIONAL, true)) {
                    $optionSupplementName = sprintf('optional-supplement-%s', $optionPrimaryName);

                    $optionNames[] = [
                        'parent' => $optionName,
                        'type' => HotelYearsOptions::OPTION_TYPE_BOOLEAN,
                        'current' => $optionSupplementName,
                    ];

                    $builder->add($optionSupplementName, CheckboxType::class, [
                        'label' => false,
                        'data' => $data->getYearOption($currentYear, $optionSupplementName, false),
                        'mapped' => false,
                        'by_reference' => false,
                        'attr' => [
                            'data-type-option' => $optionSupplementName,
                            'data-person-option-supplement' => true,
                        ],
                        'required' => false,
                    ]);
                }

                /**
                 * @var TypeSeason $typeSeason
                 */
                foreach ($data->getSeasonTypes($currentYear) as $typeSeason) {
                    $constrains = [
                        new Assert\NotNull([
                            'message' => sprintf(
                                '%s price by %s room and %s season should not be null.',
                                $optionLabel,
                                $roomSlug['title'],
                                $typeSeason->getTitle()
                            )
                        ]),
                    ];

                    if (!\in_array($optionName, HotelYearsOptions::NOT_CONSTRAINT_OPTIONS_GREATER_THAN_ZERO, true)) {
                        $constrains[] = new Assert\GreaterThan([
                            'value' => 0,
                            'message' => sprintf(
                                '%s price by %s room and %s season should be greater than 0.',
                                $optionLabel,
                                $roomSlug['title'],
                                $typeSeason->getTitle()
                            ),
                        ]);
                    }

                    $optionInnerName = sprintf('%s-%s', $optionPrimaryName, $typeSeason->getType());
                    $optionNames[] = [
                        'parent' => $optionName,
                        'type' => HotelYearsOptions::OPTION_TYPE_INTEGER,
                        'current' => $optionInnerName,
                    ];

                    $builder
                        ->add($optionInnerName, NumberType::class, [
                            'label' => false,
                            'mapped' => false,
                            'by_reference' => false,
                            'data' => $data->getYearOption($currentYear, $optionInnerName, 0),
                            'attr' => [
                                'data-type-option' => $optionInnerName,
                                'class' =>'text',
                            ],
                            'error_bubbling' => true,
                            'constraints' => $constrains,
                        ])
                    ;
                }
            }
        }

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use ($data, $currentYear, $optionNames) {
            foreach ($optionNames as $optionName) {
                $optionValue = $event->getForm()->get($optionName['current'])->getData();

                $data->setYearOption(
                    $currentYear,
                    $optionName['current'],
                    $optionName['type'],
                    $optionValue
                );
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
