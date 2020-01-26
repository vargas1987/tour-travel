<?php

namespace AltezzaTravelBundle\Form\Hotels\Type;

use AltezzaTravelBundle\Entity\Hotel;
use AltezzaTravelBundle\Entity\HotelYearsOptions;
use AltezzaTravelBundle\Entity\TypeMealPlan;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class HotelPriceMealPlanPersonType
 * @package AltezzaTravelBundle\Form\Hotels\Type
 */
class HotelPriceMealPlanPersonType extends AbstractType
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
        foreach (HotelYearsOptions::getPriceMealPlanPersonOptions($data->isTeenageRangeInit()) as $optionName => $optionLabel) {
            /** @var TypeMealPlan[]|ArrayCollection $mealPlans */
            $mealPlans = clone $data->getMealPlans();
            $mealPlans->remove(0);

            foreach ($mealPlans as $typeMealPlan) {
                $optionInnerName = sprintf('%s-%s', $optionName, $typeMealPlan->getType());
                $optionNames[] = $optionInnerName;

                $constrains = [
                    new Assert\NotNull([
                        'message' => 'Additional fee price should not be null.',
                    ]),
                ];

                if (!\in_array($optionName, HotelYearsOptions::NOT_CONSTRAINT_OPTIONS_GREATER_THAN_ZERO, true)) {
                    $constrains[] = new Assert\GreaterThan([
                        'value' => 0,
                        'message' => 'Additional fee price should be greater than 0.',
                    ]);
                }

                $builder
                    ->add($optionInnerName, NumberType::class, [
                        'label' => $optionLabel,
                        'mapped' => false,
                        'by_reference' => false,
                        'data' => $data->getYearOption($currentYear, $optionInnerName, 0),
                        'attr' => [
                            'data-type-option' => $optionInnerName,
                            'class' =>'text',
                        ],
                        'constraints' => $constrains,
                    ])
                ;
            }
        }

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use ($data, $currentYear, $optionNames) {

            foreach ($optionNames as $optionName) {
                $optionNameValue = $event->getForm()->get($optionName)->getData();

                $optionType = HotelYearsOptions::OPTION_TYPE_INTEGER;

                $data->setYearOption(
                    $currentYear,
                    $optionName,
                    $optionType,
                    $optionNameValue
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
