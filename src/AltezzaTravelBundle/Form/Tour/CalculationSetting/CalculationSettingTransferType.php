<?php

namespace AltezzaTravelBundle\Form\Tour\CalculationSetting;

use AltezzaTravelBundle\Entity\CalculationSettings\CalculationSettingTransfer;
use AltezzaTravelBundle\Entity\Settings\TransferTerritorial;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CalculationSettingTransferType
 * @package AltezzaTravelBundle\Form\Tour\CalculationSetting
 */
class CalculationSettingTransferType extends AbstractType
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
            ->add('departureTransferTerritorial', EntityType::class, [
                'label' => false,
                'class' => TransferTerritorial::class,
                'choice_label' => 'title',
                'mapped' => true,
                'required' => true,
                'error_bubbling' => true,
            ])
            ->add('arrivalTransferTerritorial', EntityType::class, [
                'label' => false,
                'class' => TransferTerritorial::class,
                'choice_label' => 'title',
                'mapped' => true,
                'required' => true,
                'error_bubbling' => true,
            ])
            ->add('price', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' =>'text',
                ],
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
            ->setDefault('data_class', CalculationSettingTransfer::class)
            ->setDefaults([
                'constraints' => [
                    new UniqueEntity([
                        'fields' => [
                            'departureTransferTerritorial',
                            'arrivalTransferTerritorial',
                        ],
                        'message' => 'Transfer with this direction already exists',
                    ]),
                ],
            ])
        ;
    }

    /**
     * @return string|null
     */
    public function getBlockPrefix()
    {
        return 'calculation_setting_transfer';
    }
}