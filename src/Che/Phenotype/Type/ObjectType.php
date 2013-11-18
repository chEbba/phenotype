<?php
/**
 * @LICENSE_TEXT
 */

namespace Che\Phenotype\Type;

/**
 * Class ObjectType
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 */
class ObjectType extends MixedType
{
    public function __toString()
    {
        return 'object';
    }

    public function isValidValue($value)
    {
        return is_object($value);
    }
}
