<?php
/**
 * @LICENSE_TEXT
 */

namespace Che\Phenotype;

/**
 * Class DataType
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 */
interface DataType 
{
    public function isValidValue($value);

    public function __toString();
}
