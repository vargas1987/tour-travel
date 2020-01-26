<?php

namespace AltezzaTravelBundle\Form\Tour\Type;

use AltezzaTravelBundle\Entity\CalculationDaySafari;
use AltezzaTravelBundle\Entity\TerritorialPark;
use AltezzaTravelBundle\Form\DataTransformer\ObjectToIdTransformer;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AbstractCalculationNightType
 * @package AltezzaTravelBundle\Form\Tour\Type
 */
class CalculationSafariDayType extends AbstractType
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
            ->add('park', HiddenType::class, [
                'label' => false,
                'mapped' => true,
                'required' => true,
                'error_bubbling' => true,
            ])
            ->add('countDays', HiddenType::class, [
                'label' => false,
                'mapped' => true,
                'required' => true,
                'error_bubbling' => true,
            ])
        ;

        $builder->get('park')->addModelTransformer(new ObjectToIdTransformer($this->registry, TerritorialPark::class));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefault('data_class', CalculationDaySafari::class)
        ;
    }
}
