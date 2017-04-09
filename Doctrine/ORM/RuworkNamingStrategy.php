<?php

namespace Ruwork\CoreBundle\Doctrine\ORM;

use Doctrine\Common\Inflector\Inflector;
use Doctrine\ORM\Mapping\NamingStrategy;

class RuworkNamingStrategy implements NamingStrategy
{
    /**
     * @var array
     */
    private $replacements;

    /**
     * @param array $replacements
     */
    public function __construct(array $replacements = [])
    {
        $this->replacements = $replacements;
    }

    /**
     * {@inheritdoc}
     */
    public function classToTableName($className)
    {
        foreach ($this->replacements as $namespace => $replacement) {
            if ($namespace === substr($className, 0, $namespaceLength = strlen($namespace))) {
                $className = $replacement.substr($className, $namespaceLength);
                $className = Inflector::tableize($className);

                return str_replace('\\', '_', $className);
            }
        }

        return $this->classToShortTableName($className);
    }

    /**
     * {@inheritdoc}
     */
    public function propertyToColumnName($propertyName, $className = null)
    {
        return Inflector::tableize($propertyName);
    }

    /**
     * {@inheritdoc}
     */
    public function embeddedFieldToColumnName(
        $propertyName,
        $embeddedColumnName,
        $className = null,
        $embeddedClassName = null
    ) {
        return $this->propertyToColumnName($propertyName).'_'.$embeddedColumnName;
    }

    /**
     * {@inheritdoc}
     */
    public function referenceColumnName()
    {
        return 'id';
    }

    /**
     * {@inheritdoc}
     */
    public function joinColumnName($propertyName, $className = null)
    {
        return $this->propertyToColumnName($propertyName).'_'.$this->referenceColumnName();
    }

    /**
     * {@inheritdoc}
     */
    function joinTableName($sourceEntity, $targetEntity, $propertyName = null)
    {
        return $this->classToShortTableName($sourceEntity).'_link_'.$this->classToShortTableName($targetEntity);
    }

    /**
     * {@inheritdoc}
     */
    function joinKeyColumnName($entityName, $referencedColumnName = null)
    {
        return $this->classToShortTableName($entityName).'_'.($referencedColumnName ?: $this->referenceColumnName());
    }

    /**
     * @param string $className
     *
     * @return string
     */
    private function classToShortTableName($className)
    {
        if (false !== $rpos = strrpos($className, '\\')) {
            $className = substr($className, $rpos + 1);
        }

        return Inflector::tableize($className);
    }
}
