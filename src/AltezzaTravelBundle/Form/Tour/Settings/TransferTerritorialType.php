<?php

namespace AltezzaTravelBundle\Form\Tour\Settings;

use AltezzaTravelBundle\Entity\Settings\TransferTerritorial;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class TransferTerritorialType
 * @package AltezzaTravelBundle\Form\Tour\Settings
 */
class TransferTerritorialType extends AbstractType
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
            ->setDefault('data_class', TransferTerritorial::class)
        ;
    }
}
