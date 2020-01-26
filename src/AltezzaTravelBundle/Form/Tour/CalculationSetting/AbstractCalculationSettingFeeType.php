<?php

namespace AltezzaTravelBundle\Form\Tour\CalculationSetting;

use AltezzaTravelBundle\Entity\CalculationSettings\AbstractCalculationSettingFee;
use AltezzaTravelBundle\Entity\TerritorialPark;
use AltezzaTravelBundle\Repository\TerritorialParkRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AbstractCalculationSettingFeeType
 * @package AltezzaTravelBundle\Form\Tour\CalculationSetting
 */
abstract class AbstractCalculationSettingFeeType extends AbstractType
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
            ->add('park', EntityType::class, [
                'label' => false,
                'class' => TerritorialPark::class,
                'query_builder' => $this->getParkQbFilter(),
                'choice_label' => 'title',
                'mapped' => true,
                'required' => true,
                'error_bubbling' => true,
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefault('data_class', AbstractCalculationSettingFee::class)
        ;
    }

    /**
     * @return \Closure
     */
    protected function getParkQbFilter()
    {
        return function(TerritorialParkRepository $er) {
            return $er->getAllSortedQB();
        };
    }
}