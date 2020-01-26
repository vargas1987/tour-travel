<?php

namespace AltezzaTravelBundle\Form\Hotels;

use AltezzaTravelBundle\Entity\Hotel;
use AltezzaTravelBundle\Entity\HotelSeason;
use AltezzaTravelBundle\Form\Hotels\Type\SeasonType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class HotelSeasonsForm
 * @package AltezzaTravelBundle\Form\Hotels
 */
class HotelSeasonsForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Hotel $data */
        $data = $builder->getData();

        $builder
            ->add('seasons', CollectionType::class, [
                'entry_type' => SeasonType::class,
                'entry_options' => [
                    'hotel' => $data,
                ],
                'mapped' => true,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Update',
                'attr' => [
                    'class' => 'admin-btn pull-right show-load-btn',
                ],
            ])
        ;

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use ($data) {
            $form = $event->getForm();
            /** @var HotelSeason[]|ArrayCollection $seasons */
            $seasons = $form->get('seasons')->getData();

            if (count($seasons) == 0) {
                $form->get('seasons')->addError(new FormError('Enter at least one season'));
            }

            /** @var HotelSeason[] $seasons */
            foreach ($seasons as $season) {
                if ($season->getDateFrom() >= $season->getDateTo()) {
                    $form->get('seasons')->addError(new FormError('The start date of the season can not be greater than or equal to the end date'));
                }

                foreach ($seasons as $intersectSeason) {
                    if ($season !== $intersectSeason
                        && (
                            ($season->getDateFrom() >= $intersectSeason->getDateFrom()
                                && $season->getDateFrom() <= $intersectSeason->getDateTo()
                            ) || ($season->getDateTo() >= $intersectSeason->getDateFrom()
                                && $season->getDateTo() <= $intersectSeason->getDateTo()
                            )
                        )
                    ) {
                        $form->get('seasons')->addError(new FormError('Crosses of periods are detected'));

                        return;
                    }
                }
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
                'data_class' => Hotel::class,
            ])
        ;
    }
}
