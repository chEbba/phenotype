<?php
/**
 * @LICENSE_TEXT
 */

namespace Che\Phenotype\Type;

use Che\Phenotype\DataType;
use Che\Phenotype\IterableType;

/**
 * Class IterableClassType
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 */
class IterableClassType extends ClassType implements IterableType
{
    private $keyType;
    private $valueType;

    public function __construct($class, DataType $keyType, DataType $valueType)
    {
        parent::__construct($class);

        if (!$this->getClass()->implementsInterface('Traversable')) {
            throw new \InvalidArgumentException('Class does not implement "Traversable" ("Iterator" or "IteratorAggregate")');
        }

        $this->keyType = $keyType;
        $this->valueType = $valueType;
    }

    /**
     * {@inheritDoc}
     */
    public function getKeyType()
    {
        return $this->keyType;
    }

    /**
     * {@inheritDoc}
     */
    public function getValueType()
    {
        return $this->valueType;
    }

    public function __toString()
    {
        return parent::__toString() . sprintf('<%s,%s>', $this->keyType, $this->valueType);
    }
}
