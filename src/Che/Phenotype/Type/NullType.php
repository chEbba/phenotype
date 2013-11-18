<?php
/**
 * @LICENSE_TEXT
 */

namespace Che\Phenotype\Type;

use Che\Phenotype\StringableType;

/**
 * Class NullType
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 */
class NullType implements StringableType
{
    public function isValidValue($value)
    {
        return $value === null;
    }

    public function __toString()
    {
        return 'null';
    }

    public function stringValue($value)
    {
        return '';
    }
}
