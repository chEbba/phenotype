<?php
/**
 * @LICENSE_TEXT
 */

namespace Che\Phenotype\Parser;

/**
 * Class SimpleTypeFactory
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 */
class SimpleTypeFactory implements TypeFactory
{
    private $typeClasses;

    public function __construct(array $typeClasses)
    {
        foreach ($typeClasses as $name => $class) {
            $this->registerTypeClass($name, $class);
        }
    }

    public function registerTypeClass($name, $class)
    {
        $this->typeClasses[$name] = $class;

        return $this;
    }

    public function supportsName($name)
    {
        return isset($this->typeClasses[$name]);
    }

    public function createType($name, array $templates)
    {
        if (!$this->supportsName($name)) {
            throw new \RuntimeException(sprintf('Unsupported name "%s"', $name));
        }

        if (!empty($templates)) {
            throw new \RuntimeException('Simple type does not support templates');
        }

        return new $this->typeClasses[$name];
    }
}
