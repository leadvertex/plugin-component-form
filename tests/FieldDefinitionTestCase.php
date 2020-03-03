<?php
/**
 * Created for plugin-component-form
 * Date: 04.02.2020
 * @author Timur Kasumov (XAKEPEHOK)
 */

namespace Leadvertex\Plugin\Components\Form;


use Leadvertex\Plugin\Components\Form\FieldDefinitions\FieldDefinition;
use PHPUnit\Framework\TestCase;

abstract class FieldDefinitionTestCase extends TestCase
{

    /** @var FieldDefinition */
    protected $definition;

    /** @var FieldDefinition */
    protected $definitionNull;

    public function testGetTitle()
    {
        $this->assertEquals('My field', $this->definition->getTitle());
    }

    public function testGetDescription()
    {
        $this->assertEquals('My description', $this->definition->getDescription());
    }

    public function testGetNullDescription()
    {
        $this->assertNull($this->definitionNull->getDescription());
    }

    public function testValidate()
    {
        $this->assertTrue($this->definition->validate(true));
        $this->assertFalse($this->definition->validate(false));
    }

    public function testGetErrors()
    {
        $this->assertEquals([], $this->definition->getErrors(true));
        $this->assertEquals(['Invalid value passed'], $this->definition->getErrors(false));
    }

    public function testGetDefault()
    {
        $this->assertEquals('My default value', $this->definition->getDefault());
    }

    public function testGetNullDefault()
    {
        $this->assertNull($this->definitionNull->getDefault());
    }

    public function testGetDefinition()
    {
        $this->assertEquals($this->getDefinitionString(), $this->definition->getDefinition());
    }

    public function testJsonSerialize()
    {
        $this->assertSame(
            json_encode([
                'title' => 'My field',
                'description' => 'My description',
                'definition' => $this->getDefinitionString(),
                'default' => 'My default value',
            ]),
            json_encode($this->definition)
        );
    }

    abstract protected function getClass(): string;

    abstract protected function getDefinitionString(): string;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var FieldDefinition $class */
        $class = $this->getClass();

        $validator = function ($value, $object) {
            if (!$value) {
                return ['Invalid value passed'];
            }
            return [];
        };

        $this->definition = new $class('My field', 'My description', $validator, 'My default value');
        $this->definitionNull = new $class('My field', null, $validator, null);
    }

}