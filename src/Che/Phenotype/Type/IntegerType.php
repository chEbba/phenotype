<?php
/**
 * @LICENSE_TEXT
 */

namespace Che\Phenotype\Type;

/**
 * Class IntType
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 */
class IntegerType extends ScalarType
{
    public function __toString()
    {
        return 'integer';
    }

    public function isValidValue($value)
    {
        return is_int($value);
    }
}
