<?php
/**
 * @LICENSE_TEXT
 */

namespace Che\Phenotype\Factory;

/**
 * Class TypeFactory
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 */
interface TypeFactory
{
    public function supportsValue($value);
    public function createType($value);
} 
