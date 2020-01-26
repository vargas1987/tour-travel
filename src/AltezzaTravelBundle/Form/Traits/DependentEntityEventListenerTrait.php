<?php

namespace AltezzaTravelBundle\Form\Traits;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Exception\InvalidConfigurationException;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

trait DependentEntityEventListenerTrait
{
    /**
     * @param FormBuilderInterface $builder
     * @param string               $newFieldName
     * @param array                $newFieldOptions
     * @param array                $hierarchyFormFields
     * @throws InvalidConfigurationException
     */
    private function addDependentEntityPostSetDataListener(
        FormBuilderInterface $builder,
        string $newFieldName,
        array $newFieldOptions,
        $hierarchyFormFields = []
    ) {
        $this->validateOptions($newFieldOptions);

        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) use ($newFieldName, $newFieldOptions, $hierarchyFormFields) {
                $data = $event->getData();
                $form = $event->getForm();

                $accessor = PropertyAccess::createPropertyAccessor();
                $dependentEntity = $accessor->getValue($data, $newFieldOptions['dependent_alias']);
                $dependentFieldValue = null;
                if ($dependentEntity) {
                    $dependentFieldValue = $accessor->getValue($dependentEntity, $newFieldOptions['dependent_field']);
                }

                $formToAdd = $form;
                foreach ($hierarchyFormFields as $formField) {
                    $formToAdd = $form->get($formField);

                }

                if (isset($newFieldOptions['dependent_is_collection']) && $newFieldOptions['dependent_is_collection']) {
                    foreach ($formToAdd as $form) {
                        $this->formModifier($form, $newFieldName, $newFieldOptions, $dependentFieldValue);
                    }
                } else {
                    $this->formModifier($formToAdd, $newFieldName, $newFieldOptions, $dependentFieldValue);
                }
            }
        );
    }

    /**
     * @param FormBuilderInterface $builder
     * @param string               $dependentFieldName
     * @param string               $newFieldName
     * @param array                $newFieldOptions
     * @param array                $hierarchyFormFields
     * @throws InvalidConfigurationException
     */
    private function addDependentEntityPostSubmitListener(
        FormBuilderInterface $builder,
        string $dependentFieldName,
        string $newFieldName,
        array $newFieldOptions,
        $hierarchyFormFields = []
    ) {
        $this->validateOptions($newFieldOptions);

        $builder->get($dependentFieldName)->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($newFieldName, $newFieldOptions, $hierarchyFormFields) {
                $form = $event->getForm();

                $accessor = PropertyAccess::createPropertyAccessor();
                $dependentEntity = $form->getData();
                $dependentFieldValue = null;
                if ($dependentEntity) {
                    $dependentFieldValue = $accessor->getValue($dependentEntity, $newFieldOptions['dependent_field']);
                }

                $formToAdd = $form->getParent();
                foreach ($hierarchyFormFields as $formField) {
                    $formToAdd = $formToAdd->get($formField);
                }

                if (isset($newFieldOptions['dependent_is_collection']) && $newFieldOptions['dependent_is_collection']) {
                    foreach ($formToAdd as $form) {
                        $this->formModifier($form, $newFieldName, $newFieldOptions, $dependentFieldValue);
                    }
                } else {
                    $this->formModifier($formToAdd, $newFieldName, $newFieldOptions, $dependentFieldValue);
                }
            }
        );
    }

    /**
     * @param array $options
     */
    private function validateOptions(array $options)
    {
        if (null === $options['dependent_class']) {
            throw new InvalidConfigurationException('Option "dependent_class" is empty');
        }

        if (null === $options['dependent_alias']) {
            throw new InvalidConfigurationException('Option "dependent_alias" is empty');
        }

        if (null === $options['dependent_field']) {
            throw new InvalidConfigurationException('Option "dependent_field" is empty');
        }
    }

    /**
     * @param FormInterface $form
     * @param string        $fieldName
     * @param array         $options
     * @param null          $dependentFieldValue
     */
    private function formModifier(FormInterface $form, string $fieldName, array $options, $dependentFieldValue = null)
    {
        $options['query_builder'] = function (EntityRepository $er) use ($options, $dependentFieldValue) {
            if (!$dependentFieldValue) {
                return $er->createQueryBuilder('a');
            }

            $qb = $er->createQueryBuilder('a')
                ->innerJoin(
                    $options['dependent_class'],
                    $options['dependent_alias'],
                    'inner',
                    sprintf('a.%s = %s.%s',
                        $options['dependent_alias'],
                        $options['dependent_alias'],
                        $options['dependent_field']
                    )
                )
                ->andWhere($options['dependent_alias'].'.'.$options['dependent_field'].' = :'.$options['dependent_field'])
                ->setParameter($options['dependent_field'], $dependentFieldValue);

            return $qb;
        };

        unset($options['dependent_class']);
        unset($options['dependent_is_collection']);
        unset($options['dependent_alias']);
        unset($options['dependent_field']);

        $form->add($fieldName, EntityType::class, $options);
    }
}
