<?php

namespace AltezzaTravelBundle\Form\Hotels\Type;

use AltezzaTravelBundle\Entity\Hotel;
use AltezzaTravelBundle\Entity\HotelSeason;
use AltezzaTravelBundle\Entity\TypeSeason;
use AltezzaTravelBundle\Repository\TypeSeasonRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class HotelRoomAccommodationType
 * @package AltezzaTravelBundle\Form\Hotels\Type
 */
class SeasonType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Hotel $hotel */
        $hotel = $options['hotel'];

        $builder
            ->add('dateFrom', DateType::class, [
                'label' => false,
                'required' => true,
                'html5' => true,
                'widget' => 'single_text',
                'format' => 'd MMM yyyy',
                'attr' => [
                    'data-type' => 'date-from',
                    'data-format' => 'd M yy',
                    //'data-mask' => '99/99/9999',
                    'data-placeholder' => 'dd MMM yyyy',
                    'autocomplete' => 'off',
                ],
                'constraints' => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Date(),
                ],
            ])
            ->add('dateTo', DateType::class, [
                'label' => false,
                'required' => true,
                'html5' => true,
                'widget' => 'single_text',
                'format' => 'd MMM yyyy',
                'attr' => [
                    'data-type' => 'date-to',
                    'data-format' => 'd M yy',
                    //'data-mask' => '99/99/9999',
                    'data-placeholder' => 'dd MMM yyyy',
                    'autocomplete' => 'off',
                ],
                'constraints' => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Date(),
                ],
            ])
            ->add('type', EntityType::class, [
                'class' => TypeSeason::class,
                'query_builder' => function(TypeSeasonRepository $er) use ($hotel) {
                    return $er->createQueryBuilder('typeSeason')
                        ->leftJoin('typeSeason.hotelSeasonTypes', 'hotelSeasonType')
                        ->where('hotelSeasonType.hotel = :hotel')
                        ->setParameter('hotel', $hotel)
                        ->orderBy('typeSeason.sort', 'ASC')
                    ;
                },
                'attr' => [
                    'data-type' => 'season',
                ],
                'choice_label' => 'title',
                'label' => false,
                'required' => true,
                'placeholder' => '------',
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
                'data_class' => HotelSeason::class,
            ])
            ->setRequired('hotel')
        ;
    }
}
