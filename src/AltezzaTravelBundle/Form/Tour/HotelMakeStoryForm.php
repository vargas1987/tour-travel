<?php

namespace AltezzaTravelBundle\Form\Tour;

use AltezzaTravelBundle\Entity\HotelMakeStory;
use AltezzaTravelBundle\Entity\HotelMakeStoryExtraOptions;
use AltezzaTravelBundle\Entity\HotelMakeStoryProgram;
use AltezzaTravelBundle\Form\Tour\Type\HotelMakeStoryExtraOptionType;
use AltezzaTravelBundle\Form\Tour\Type\HotelMakeStoryProgramDetailsType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints as Assert;

class HotelMakeStoryForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('language', ChoiceType::class, [
                'label' => 'Choose a language:',
                'required' => true,
                'choices' => [
                    'English' => 'en',
                    'Russian' =>  'ru',
                ],
                'placeholder' => false,
            ])
            ->add('tariff', ChoiceType::class, [
                'label' => 'Выбрать тариф:',
                'required' => true,
                'choices' => [
                    'Premium' => 'premium',
                    'Ultimate' =>  'ultimate',
                    'Medium' =>  'medium',
                    'Economical' =>  'economical',
                ],
                'placeholder' => false,
            ])
            ->add('program', ChoiceType::class, [
                'label' => 'Choose a program:',
                'required' => false,
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    'CLIMBING' => 'climbing',
                    'SAFARI' => 'safari',
                    'CLIMBING & SAFARI' =>  'climbing-safari',
                ],
                'placeholder' => false,
                'constraints' => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                ],
            ])
            ->add('isHideLocateDates', CheckboxType::class, [
                'label'    => 'Скрыть даты',
                'required' => false,
            ])
            ->add($this->preparePeriod($builder))
            ->add('programDetails', CollectionType::class, [
                'entry_type' => HotelMakeStoryProgramDetailsType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
                'error_bubbling' => true,
                'mapped' => true,
                'data' => [null],
                'constraints' => [
                    new Constraints\Count(['min' => 1, 'max' => 10]),
                    new Constraints\Valid(),
                ],
            ])
            ->add('extraOptions', CollectionType::class, [
                'entry_type' => HotelMakeStoryExtraOptionType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
                'error_bubbling' => true,
                'mapped' => true,
                'data' => [null],
                'constraints' => [
                    new Constraints\Count(['min' => 1, 'max' => 10]),
                    new Constraints\Valid(),
                ],
            ])
        ;

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();

            $period = $form->get('period');
            $dateFrom = $period->get('locateSinceAt')->getData();
            $dateTo = $period->get('locateEndAt')->getData();

            if ($dateFrom >= $dateTo) {
                $period->addError(new FormError('The start date can not be greater than or equal to the end date'));
            }
            /** @var HotelMakeStory $story */
            $story = $form->getData();

            /** @var HotelMakeStoryProgram $programDetail */
            foreach ($form->get('programDetails')->getData() as $programDetail) {
                $programDetail->setMakeStory($story);
            }

            /** @var HotelMakeStoryExtraOptions $extraOption */
            foreach ($form->get('extraOptions')->getData() as $extraOption) {
                $extraOption->setMakeStory($story);
            }
        });
    }

    /**
     * @param FormBuilderInterface $builder
     *
     * @return FormBuilderInterface
     */
    protected function preparePeriod(FormBuilderInterface $builder)
    {
        return $builder
            ->create('period', FormType::class, [
                'label' => false,
                'error_bubbling' => false,
                'inherit_data' => true,
            ])
            ->add('locateSinceAt', DateType::class, [
                'label' => 'Начало программы',
                'required' => true,
                'html5' => true,
                'widget' => 'single_text',
                'format' => 'd MMM yyyy',
                'placeholder' => false,
                'attr' => [
                    'data-behavior' => 'date-locate-since',
                ],
                'constraints' => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Date(),
                ],
            ])
            ->add('locateEndAt', DateType::class, [
                'label' => 'Конец программы',
                'required' => true,
                'html5' => true,
                'widget' => 'single_text',
                'format' => 'd MMM yyyy',
                'placeholder' => false,
                'attr' => [
                    'data-behavior' => 'date-locate-end',
                ],
                'constraints' => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Date(),
                ],
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => HotelMakeStory::class,
            ]);
    }
}
