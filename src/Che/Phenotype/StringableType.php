<?php
/**
 * @LICENSE_TEXT
 */

namespace Che\Phenotype;

/**
 * Class StringableType
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 */
interface StringableType extends DataType
{
    public function stringValue($value);
} 
