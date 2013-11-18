<?php
/**
 * @LICENSE_TEXT
 */

namespace Che\Phenotype;

/**
 * Class IterableType
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 */
interface IterableType extends DataType
{
    public function getKeyType();
    public function getValueType();
}
