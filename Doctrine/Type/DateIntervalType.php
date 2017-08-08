<?php

namespace Ruvents\RuworkBundle\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

/**
 * @deprecated use Ruvents\DoctrineBundle\Doctrine\Type\DateIntervalType
 */
class DateIntervalType extends Type
{
    const NAME = 'dateinterval';

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        @trigger_error(sprintf('Class "%s" is deprecated since 0.5.2 and will be removed in 0.6.0. Use "Ruvents\DoctrineBundle\Doctrine\Type\DateIntervalType".', __CLASS__), E_USER_DEPRECATED);

        return self::NAME;
    }

    /**
     * {@inheritdoc}
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        $fieldDeclaration['length'] = 255;
        $fieldDeclaration['fixed'] = true;

        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        if ($value instanceof \DateInterval) {
            return $value->format('P%YY%MM%DDT%HH%IM%SS');
        }

        throw ConversionException::conversionFailedFormat($value, $this->getName(), 'null, DateInterval');
    }

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value || $value instanceof \DateInterval) {
            return $value;
        }

        try {
            return new \DateInterval($value);
        } catch (\Exception $exception) {
            throw ConversionException::conversionFailedFormat($value, $this->getName(), 'P%YY%MM%DDT%HH%IM%SS');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}
