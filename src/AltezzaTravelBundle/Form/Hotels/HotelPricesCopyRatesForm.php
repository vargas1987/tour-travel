<?php

namespace AltezzaTravelBundle\Form\Hotels;

use AltezzaTravelBundle\Entity\Hotel;
use AltezzaTravelBundle\Form\DataTransformer\ObjectToIdTransformer;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class HotelPricesCopyRatesForm
 * @package AltezzaTravelBundle\Form\Hotels
 */
class HotelPricesCopyRatesForm extends AbstractType
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
        $transformer = new ObjectToIdTransformer($this->registry, Hotel::class);

        $builder
            ->add('hotel', HiddenType::class)
            ->add('year', HiddenType::class)
            ->get('hotel')->addModelTransformer($transformer)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }

}