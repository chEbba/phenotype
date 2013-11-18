<?php
/**
 * @LICENSE_TEXT
 */

namespace Che\Phenotype\Type;

use Che\Phenotype\DataType;
use Che\Phenotype\IterableType;

/**
 * Class ArrayType
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 */
class ArrayType implements IterableType
{
    private $valueType;
    private $keyType;

    public function __construct(StringableType $keyType, DataType $valueType)
    {

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
        return sprintf('array<%s,%s>', $this->keyType, $this->valueType);
    }

    public function isValidValue($value)
    {
        return is_array($value);
    }
}
