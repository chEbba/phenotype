<?php
/**
 * @LICENSE_TEXT
 */

namespace Che\Phenotype\Tests\Parser;

use Che\Phenotype\DataType;
use Che\Phenotype\Parser\TypeParser;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Class TypeParserTest
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 */
class TypeParserTest extends TestCase
{
    /** @var MockObject */
    private $factory;
    /** @var TypeParser */
    private $parser;

    protected function setUp()
    {
        $this->factory = $this->getMock('Che\Phenotype\Parser\TypeFactory');
        $this->parser = new TypeParser($this->factory);
    }

    /**
     * @test
     * @dataProvider simpleTypes
     *
     * @param string $input
     * @param string $category
     */
    public function parseSimpleType($input, $category)
    {
        $expectedType = $this->getTypeMock($input);

        $this->factory
            ->expects($this->once())
            ->method('createType')
            ->with($input)
            ->will($this->returnValue($expectedType));

        $type = $this->parser->parse($input);

        $this->assertSame($expectedType, $type, sprintf('Expected type is the same for "%s"', $category));
    }

    public function simpleTypes()
    {
        return [
            ['integer', 'Simple word'],
            ['Foo\Bar', 'Namespaced name'],
            ['\Foo\Bar', 'Full qualified name'],
            ['Foo123\Bs_12n_F', 'Special symbols']
        ];
    }

    /**
     * @test template type parsing
     * @dataProvider templateTypes
     *
     * @param string $input
     * @param string $typeName
     * @param array  $templateTypeNames
     */
    public function parseTemplates($input, $typeName, array $templateTypeNames)
    {
        $templates = [];
        foreach ($templateTypeNames as $i => $templateTypeName) {
            $this->factory
                ->expects($this->at($i))
                ->method('createType')
                ->with($templateTypeName, [])
                ->will($this->returnValue($templates[] = $this->getTypeMock($templateTypeName)))
            ;
        }
        $this->factory
            ->expects($this->at(count($templates)))
            ->method('createType')
            ->with($typeName, $templates)
            ->will($this->returnValue($type = $this->getTypeMock($typeName)))
        ;

        $this->assertEquals($type, $this->parser->parse($input));
    }

    public function templateTypes()
    {
        return [
            ['Foo\Bar <integer>', 'Foo\Bar', ['integer']],
            ['Foo\Bar<integer, string>', 'Foo\Bar', ['integer', 'string']],
            ['Foo\Bar<Bar\Baz, string>', 'Foo\Bar', ['Bar\Baz', 'string']],
            ['Foo\Bar<Bar\Baz, Bar\Foo>', 'Foo\Bar', ['Bar\Baz', 'Bar\Foo']],
            ['Foo\Bar<integer, Bar\Foo>', 'Foo\Bar', ['integer', 'Bar\Foo']]
        ];
    }

    /**
     * @test multi type declaration with |
     */
    public function multiTypes()
    {
        $types = [];
        foreach (['Foo\Bar\Baz', 'integer', '\Foo\Bar'] as $i => $typeName) {
            $this->factory
                ->expects($this->at($i))
                ->method('createType')
                ->with($typeName)
                ->will($this->returnValue($types[] = $this->getTypeMock($typeName)))
            ;
        }

        $type = $this->parser->parse('Foo\Bar\Baz|integer| \Foo\Bar');

        $this->assertInstanceOf('Che\Phenotype\Type\MultiType', $type);
        $subTypes = $type->getSubTypes();
        $this->assertCount(count($types), $subTypes);
        foreach ($subTypes as $i => $type) {
            $this->assertSame($types[$i], $type);
        }
    }

    /**
     * @test multiple types as template
     */
    public function multipleTemplateType()
    {
        $subTypes = [];
        $this->factory
            ->expects($this->at(0))
            ->method('createType')
            ->will($this->returnValue($subTypes[] = $this->getTypeMock('integer')))
        ;
        $this->factory
            ->expects($this->at(1))
            ->method('createType')
            ->will($this->returnValue($subTypes[] = $this->getTypeMock('Bar\Baz')))
        ;
        $this->factory
            ->expects($this->at(2))
            ->method('createType')
            ->with('Foo\Bar', $this->callback(function (array $templates) use ($subTypes) {
                $this->assertCount(1, $templates);
                $template = current($templates);
                $this->assertInstanceOf('Che\Phenotype\Type\MultiType', $template);
                $this->assertEquals($template->getSubTypes(), $subTypes);

                return true;
            }))
            ->will($this->returnValue($expectedType = $this->getTypeMock('Bar\Baz')))
        ;

        $this->assertSame($expectedType, $this->parser->parse('Foo\Bar<integer| Bar\Baz>'));
    }

    private function getTypeMock($name)
    {
        $type = $this->getMock('Che\Phenotype\DataType');
        $type
            ->expects($this->any())
            ->method('__toString')
            ->will($this->returnValue($name))
        ;

        return $type;
    }
}
