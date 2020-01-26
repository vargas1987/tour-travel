<?php

namespace AltezzaTravelBundle\Form\Tour\Type;

use AltezzaTravelBundle\Entity\AbstractCalculationNight;
use AltezzaTravelBundle\Entity\Hotel;
use AltezzaTravelBundle\Entity\HotelRoom;
use AltezzaTravelBundle\Entity\TypeAccommodation;
use AltezzaTravelBundle\Entity\TypeMealPlan;
use AltezzaTravelBundle\Form\DataTransformer\ObjectToIdTransformer;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AbstractCalculationNightType
 * @package AltezzaTravelBundle\Form\Tour\Type
 */
class AbstractCalculationNightType extends AbstractType
{
    /** @var ManagerRegistry */
    protected $registry;

    /**
     * HotelSeasonTypeEntryType constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('hotel', HiddenType::class, [
                'label' => false,
                'mapped' => true,
                'required' => true,
                'error_bubbling' => true,
            ])
            ->add('mealPlanType', HiddenType::class, [
                'label' => false,
                'mapped' => true,
                'required' => true,
            ])
            ->add('room', HiddenType::class, [
                'mapped' => true,
                'required' => true,
                'error_bubbling' => true,
            ])
            ->add('count', NumberType::class, [
                'label' => false,
                'attr' => [
                    'class' =>'text',
                ],
                'required' => true,
                'error_bubbling' => true,
            ])
            ->add('accommodation', HiddenType::class, [
                'label' => false,
                'mapped' => true,
                'required' => true,
                'error_bubbling' => true,
            ])
        ;

        $builder->get('hotel')->addModelTransformer(new ObjectToIdTransformer($this->registry, Hotel::class));
        $builder->get('mealPlanType')->addModelTransformer(new ObjectToIdTransformer($this->registry, TypeMealPlan::class, 'type'));
        $builder->get('room')->addModelTransformer(new ObjectToIdTransformer($this->registry, HotelRoom::class));
        $builder->get('accommodation')->addModelTransformer(new ObjectToIdTransformer($this->registry, TypeAccommodation::class, 'type'));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefault('data_class', AbstractCalculationNight::class)
        ;
    }
}
