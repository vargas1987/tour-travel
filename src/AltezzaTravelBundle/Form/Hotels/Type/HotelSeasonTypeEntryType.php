<?php

namespace AltezzaTravelBundle\Form\Hotels\Type;

use AltezzaTravelBundle\Entity\HotelSeasonType;
use AltezzaTravelBundle\Entity\TypeSeason;
use AltezzaTravelBundle\Form\DataTransformer\SeasonTypeTransformer;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class HotelSeasonTypeEntryType
 * @package AltezzaTravelBundle\Form\Hotels\Type
 */
class HotelSeasonTypeEntryType extends AbstractType
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
        $transformer = new SeasonTypeTransformer($this->registry, TypeSeason::class, 'title');

        $builder
            ->add('seasonType', TextType::class, [
                'by_reference' => false,
                'attr' => [
                    'class' =>'text',
                ],
            ])
            ->get('seasonType')->addModelTransformer($transformer);
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => HotelSeasonType::class,
            ])
        ;
    }
}
