<?php
/**
 * @LICENSE_TEXT
 */

namespace Che\Phenotype\Parser;

/**
 * Class TypeFactory
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 */
interface TypeFactory 
{
    public function supportsName($name);
    public function createType($name, array $templates);
}
