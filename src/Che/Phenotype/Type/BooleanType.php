<?php
/**
 * @LICENSE_TEXT
 */

namespace Che\Phenotype\Type;

/**
 * Class BooleanType
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 */
class BooleanType extends ScalarType
{
    public function __toString()
    {
        return 'boolean';
    }

    public function isValidValue($value)
    {
        return is_bool($value);
    }
} 
