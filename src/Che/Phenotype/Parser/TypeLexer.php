<?php
/**
 * @LICENSE_TEXT
 */

namespace Che\Phenotype\Parser;

use Doctrine\Common\Lexer\AbstractLexer;

/**
 * Class TypeLexer
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 */
class TypeLexer extends AbstractLexer
{
    const T_NONE = 0;

    const T_IDENTIFIER = 1;
//    const T_NAMESPACE_SEPARATOR = 2;
    const T_TEMPLATE_OPEN = 3;
    const T_TEMPLATE_CLOSE = 4;
    const T_COMMA = 5;
    const T_TYPE_OR = 6;

    private $separators = [
        '<' => self::T_TEMPLATE_OPEN,
        '>' => self::T_TEMPLATE_CLOSE,
        ',' => self::T_COMMA,
        '|' => self::T_TYPE_OR
    ];

    /**
     * Lexical catchable patterns.
     *
     * @return array
     */
    protected function getCatchablePatterns()
    {
        return [
            '[a-z_\\\][a-z0-9_\:\\\]*[a-z]{1}', // FQN
        ];
    }

    /**
     * Lexical non-catchable patterns.
     *
     * @return array
     */
    protected function getNonCatchablePatterns()
    {
        return ['\s+', '(.)'];
    }

    /**
     * Retrieve token type. Also processes the token value if necessary.
     *
     * @param string $value
     * @return integer
     */
    protected function getType(&$value)
    {
        if (isset($this->separators[$value])) {
            return $this->separators[$value];
        }

        if ($value[0] === '\\' || ctype_alpha($value[0])) {
            return self::T_IDENTIFIER;
        }

        return self::T_NONE;
    }
}
