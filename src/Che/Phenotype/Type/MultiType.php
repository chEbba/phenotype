<?php
/**
 * @LICENSE_TEXT
 */

namespace Che\Phenotype\Type;

use Che\Phenotype\DataType;

/**
 * Class MultiType
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 */
class MultiType implements DataType
{
    /**
     * @var DataType[]
     */
    private $subTypes = [];

    public function __construct(array $types)
    {
        foreach ($types as $type) {
            $this->addSubType($type);
        }
    }

    private function addSubType(DataType $type)
    {
        $this->subTypes[] = $type;
    }

    /**
     * @return DataType[]
     */
    public function getSubTypes()
    {
        return $this->subTypes;
    }

    public function isValidValue($value)
    {
        foreach ($this->subTypes as $type) {
            if ($type->isValidValue($value)) {
                return true;
            }
        }

        return false;
    }

    public function __toString()
    {
        return implode('|', $this->subTypes);
    }
}
