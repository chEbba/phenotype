<?php
/**
 * @LICENSE_TEXT
 */

namespace Che\Phenotype\Type;

/**
 * Class FloatType
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 */
class FloatType extends ScalarType
{
    public function __toString()
    {
        return 'float';
    }

    public function isValidValue($value)
    {
        return is_float($value);
    }
} 
