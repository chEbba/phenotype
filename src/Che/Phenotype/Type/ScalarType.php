<?php
/**
 * @LICENSE_TEXT
 */

namespace Che\Phenotype\Type;

use Che\Phenotype\StringableType;

/**
 * Class ScalarType
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 */
class ScalarType extends MixedType implements StringableType
{
    public function __toString()
    {
        return 'scalar';
    }

    public function isValidValue($value)
    {
        return is_scalar($value);
    }

    public function stringValue($value)
    {
        return (string) $value;
    }
}
