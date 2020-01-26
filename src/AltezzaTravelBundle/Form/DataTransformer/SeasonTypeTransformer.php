<?php

namespace AltezzaTravelBundle\Form\DataTransformer;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class SeasonTypeTransformer
 * @package AltezzaTravelBundle\Form\DataTransformer
 */
class SeasonTypeTransformer extends ObjectToIdTransformer
{
    /**
     * @inheritdoc
     */
    public function reverseTransform($id)
    {
        if (!$id || $id == '__id__') {
            return null;
        }

        $accessor = PropertyAccess::createPropertyAccessor();
        if ($this->multiple) {
            $ids = explode(',', $id);
            $result = $this->getRepository()->findBy([$this->property => $ids]);
        } else {
            $result = $this->getRepository()->findOneBy([$this->property => $id]);

            if (null === $result) {
                $result = new $this->class;
                $accessor->setValue($result, $this->property, $id);
                $this->getManager()->persist($result);
            }
        }

        return $result;
    }
}