<?php

namespace Ruvents\RuworkBundle\PropertyInfo;

use Symfony\Component\PropertyInfo\PropertyTypeExtractorInterface;
use Symfony\Component\PropertyInfo\Type;

class NullableTypeExtractorDecorator implements PropertyTypeExtractorInterface
{
    /**
     * @var PropertyTypeExtractorInterface
     */
    private $extractor;

    public function __construct(PropertyTypeExtractorInterface $extractor)
    {
        $this->extractor = $extractor;
    }

    /**
     * {@inheritdoc}
     */
    public function getTypes($class, $property, array $context = [])
    {
        $types = $this->extractor->getTypes($class, $property, $context);

        if (null === $types) {
            return null;
        }

        return array_map(function (Type $type) {
            return new Type(
                $type->getBuiltinType(),
                true,
                $type->getClassName(),
                $type->isCollection(),
                $type->getCollectionKeyType(),
                $type->getCollectionValueType()
            );
        }, $types);
    }
}
