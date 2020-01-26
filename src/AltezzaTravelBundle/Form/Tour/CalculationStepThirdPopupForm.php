<?php

namespace AltezzaTravelBundle\Form\Tour;

use AltezzaTravelBundle\Entity\Calculation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CalculationStepThirdForm
 * @package AltezzaTravelBundle\Form\Tour
 */
class CalculationStepThirdPopupForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => false,
                'mapped' => true,
                'required' => true,
                'constraints' => [
                    new Assert\NotNull([
                        'message' => 'Fill in the "Calculation title" field',
                    ]),
                    new Assert\NotBlank([
                        'message' => 'Fill in the "Calculation title" field',
                    ]),
                ],
                'error_bubbling' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Save',
                'attr' => [
                    'class' => 'admin-btn',
                ],
            ])
        ;

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $calculation = $event->getData();
            $calculation->setStatus(Calculation::CALCULATION_STATUS_TEMPLATE);
        });
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'csrf_protection' => false,
                'data_class' => Calculation::class,
                'error_bubbling' => true,
            ])
        ;
    }
}