<?php

namespace AltezzaTravelBundle\Form\Tour;

use AltezzaTravelBundle\Entity\AbstractCalculationPerson;
use AltezzaTravelBundle\Entity\Calculation;
use AltezzaTravelBundle\Form\Tour\Type\CalculationAdultPersonType;
use AltezzaTravelBundle\Form\Tour\Type\CalculationChildPersonType;
use AltezzaTravelBundle\Form\Tour\Type\CalculationFlightType;
use AltezzaTravelBundle\Form\Tour\Type\CalculationPersonCollectionType;
use AltezzaTravelBundle\Form\Tour\Type\CalculationTransferType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CalculationStepOneForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Calculation $data */
        $data = $builder->getData();

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
                    'data-placeholder' => 'dd MMM yyyy',
                    'autocomplete' => 'off',
                ],
                'error_bubbling' => true,
                'constraints' => [
                    new Assert\NotNull([
                        'message' => 'Fill in the "Date From" field',
                    ]),
                    new Assert\NotBlank([
                        'message' => 'Fill in the "Date From" field',
                    ]),
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
                    'data-placeholder' => 'dd MMM yyyy',
                    'autocomplete' => 'off',
                ],
                'error_bubbling' => true,
                'constraints' => [
                    new Assert\NotNull([
                        'message' => 'Fill in the "Date To" field',
                    ]),
                    new Assert\NotBlank([
                        'message' => 'Fill in the "Date To" field',
                    ]),
                    new Assert\Date(),
                ],
            ])
        ;

        $builder
            ->add($period)
            ->add('countSafariDays', NumberType::class, [
                'label' => false,
                'mapped' => true,
                'attr' => [
                    'class' =>'text',
                ],
                'required' => true,
                'constraints' => [
                    new Assert\NotNull([
                        'message' => 'Fill in the "Number safari days" field',
                    ]),
                    new Assert\NotBlank([
                        'message' => 'Fill in the "Number safari days" field',
                    ]),
                ],
            ])
            ->add('transfers', CollectionType::class, [
                'label' => false,
                'data' => $data->getTransfers(),
                'entry_type' => CalculationTransferType::class,
                'mapped' => true,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'error_bubbling' => false,
            ])
            ->add('flights', CollectionType::class, [
                'label' => false,
                'data' => $data->getFlights(),
                'entry_type' => CalculationFlightType::class,
                'mapped' => true,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'error_bubbling' => false,
            ])
            ->add('foreigners', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'Foreigners' => true,
                    'East African' => false,
                ],
                'expanded' => true,
                'multiple' => false,
                'required' => true,
            ])
            ->add('adultPersons', CalculationPersonCollectionType::class, [
                'label' => false,
                'required' => true,
                'entry_type' => CalculationAdultPersonType::class,
                'person_type' => AbstractCalculationPerson::TYPE_ADULT,
                'data' => $data->getId()? $data->getAdultPersons() : [null],
                'allow_add' => false,
                'allow_delete' => false,
                'delete_empty' => false,
            ])
            ->add('childPersons', CalculationPersonCollectionType::class, [
                'label' => false,
                'required' => false,
                'entry_type' => CalculationChildPersonType::class,
                'person_type' => AbstractCalculationPerson::TYPE_CHILD,
                'data' => $data->getId()? $data->getChildPersons() : null,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Next',
                'attr' => [
                    'class' => 'admin-btn pull-right show-load-btn',
                ],
            ])
        ;

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();

            $period = $form->get('period');
            $dateFrom = $period->get('dateFrom')->getData()->setTime(0,0,0);
            $dateTo = $period->get('dateTo')->getData()->setTime(0,0,0);

            $today = new \DateTime('today 00:00:00');
            if ($dateFrom < $today) {
                $period->addError(new FormError('The start date cannot be less than to the today'));
            }

            if ($dateFrom > $dateTo) {
                $period->addError(new FormError('The start date cannot be greater than to the end date'));
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
                'csrf_protection' => false,
                'data_class' => Calculation::class,
            ])
        ;
    }
}
