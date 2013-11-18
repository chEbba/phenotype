<?php
/**
 * @LICENSE_TEXT
 */

namespace Che\Phenotype\Type;

use Che\Phenotype\DataType;

/**
 * Class MixedType
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 */
class MixedType implements DataType
{
    public function __toString()
    {
        return 'mixed';
    }

    public function isValidValue($value)
    {
        return true;
    }
}
