<?php
/**
 * @LICENSE_TEXT
 */

namespace Che\Phenotype\Parser;

use Che\Phenotype\Type\MultiType;

/**
 * Class TypeParser
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 */
class TypeParser
{
    private $factory;
    private $lexer;

    public function __construct(TypeFactory $factory)
    {
        $this->factory = $factory;
        $this->lexer = new TypeLexer();
    }

    public function parse($input)
    {
        $this->lexer->setInput($input);

        if (!$this->lexer->moveNext()) {
            return null;
        }

        $type = $this->parseType();

        if ($this->lexer->lookahead) {
            throw new \RuntimeException('End of type declaration expected');
        }

        return $type;
    }

    /**
     * @return MultiType|null
     */
    private function parseType()
    {
        $types = [];
        do {
            $types[] = $this->parseSingleType();
            $nextType = false;
            if ($this->lexer->isNextToken(TypeLexer::T_TYPE_OR)) {
                $this->lexer->moveNext();
                $nextType = true;
            }
        } while ($nextType);

        if (count($types) === 1) {
            return $types[0];
        }

        return new MultiType($types);
    }

    private function parseSingleType()
    {
        if (!$this->lexer->isNextToken(TypeLexer::T_IDENTIFIER) ) {
            throw new \InvalidArgumentException('Not an identifier');
        }

        $nameToken = $this->lexer->lookahead;
        $this->lexer->moveNext();

        $templates = [];
        if ($this->lexer->isNextToken(TypeLexer::T_TEMPLATE_OPEN)) {
            $this->lexer->moveNext();
            do {
                $templates[] = $this->parseType();
                $nextTemplate = false;
                if ($this->lexer->isNextToken(TypeLexer::T_COMMA)) {
                    $nextTemplate = true;
                    $this->lexer->moveNext();
                }
            } while ($nextTemplate);

            if (!$this->lexer->isNextToken(TypeLexer::T_TEMPLATE_CLOSE)) {
                throw new \InvalidArgumentException('Expected end of templates');
            }
            $this->lexer->moveNext();
        }

        return $this->factory->createType($nameToken['value'], $templates);
    }
}
