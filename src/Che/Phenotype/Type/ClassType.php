<?php
/**
 * @LICENSE_TEXT
 */

namespace Che\Phenotype\Type;

/**
 * Class ClassType
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 */
class ClassType extends ObjectType
{
    private $class;
    private $reflection;

    public function __construct($class)
    {
        $this->class = $class;
        $this->reflection = new \ReflectionClass($class);
    }

    public function __toString()
    {
        return $this->class;
    }

    /**
     * @return \ReflectionClass
     */
    public function getClass()
    {
        return $this->reflection;
    }

    public function isValidValue($value)
    {
        return $this->reflection->isInstance($value);
    }
}
