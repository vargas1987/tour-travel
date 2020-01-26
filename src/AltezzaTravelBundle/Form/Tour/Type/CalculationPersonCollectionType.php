<?php

namespace AltezzaTravelBundle\Form\Tour\Type;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CalculationPersonCollectionType
 * @package AltezzaTravelBundle\Form\Tour\Type
 */
class CalculationPersonCollectionType extends CollectionType
{
    /**
     * @param FormView      $view
     * @param FormInterface $form
     * @param array         $options
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        if (!array_key_exists('prototype', $view->vars)) {
            $view->vars['prototype'] = false;
        }
        $view->vars['person_type'] = $options['person_type'];
    }

    /**
     * @return null|string
     */
    public function getBlockPrefix()
    {
        return 'calculation_person_collection';
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setRequired('person_type')
        ;

        parent::configureOptions($resolver);
    }
}
