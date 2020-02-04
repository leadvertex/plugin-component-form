<?php
/**
 * Created for plugin-component-form
 * Date: 04.02.2020
 * @author Timur Kasumov (XAKEPEHOK)
 */

namespace Leadvertex\Plugin\Components\Form\FieldDefinitions;

use Leadvertex\Plugin\Components\Form\FieldDefinitions\ListOfEnum\Limit;
use Leadvertex\Plugin\Components\Form\FieldDefinitions\ListOfEnum\Values\StaticValues;
use Leadvertex\Plugin\Components\Form\FieldDefinitions\ListOfEnum\Values\ValuesListInterface;
use Leadvertex\Plugin\Components\Form\FieldDefinitionTestCase;

class ListOfEnumDefinitionTest extends FieldDefinitionTestCase
{

    /** @var Limit */
    private $limit;

    /** @var ValuesListInterface */
    private $values;

    /** @var ListOfEnumDefinition */
    protected $definition;

    /** @var ListOfEnumDefinition */
    protected $definitionNull;

    public function testGetLimit()
    {
        $this->assertSame($this->limit, $this->definition->getLimit());
    }

    public function testGetNullLimit()
    {
        $this->assertNull($this->definitionNull->getLimit());
    }

    public function testGetValuesList()
    {
        $this->assertSame($this->values, $this->definition->getValues());
    }

    protected function getClass(): string
    {
        return ListOfEnumDefinition::class;
    }

    protected function getDefinitionString(): string
    {
        return 'listOfEnum';
    }

    protected function setUp(): void
    {
        $validator = function ($value) {
            if (!$value) {
                return ['Invalid value passed'];
            }
            return [];
        };

        $this->limit = new Limit(1, 10);
        $this->values = new StaticValues([
            '0' => 'zero',
            '1' => 'one',
            '2' => 'two',
        ]);

        $this->definition = new ListOfEnumDefinition(
            'My field',
            'My description',
            $validator,
            $this->values,
            $this->limit,
            'My default value'
        );

        $this->definitionNull = new ListOfEnumDefinition(
            'My field',
            null,
            $validator,
            $this->values,
            null,
            null
        );
    }
}
