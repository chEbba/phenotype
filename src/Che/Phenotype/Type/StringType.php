<?php
/**
 * @LICENSE_TEXT
 */

namespace Che\Phenotype\Type;

/**
 * Class StringType
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 */
class StringType extends ScalarType
{
    public function __toString()
    {
        return 'string';
    }

    public function isValidValue($value)
    {
        return is_string($value);
    }
} 
