<?php

namespace Leadvertex\Plugin\Scheme\FieldDefinitions;


use Exception;
use Leadvertex\Plugin\Scheme\Components\Lang;
use Leadvertex\Plugin\Scheme\Components\i18n;
use PHPUnit\Framework\TestCase;

class EnumDefinitionTest extends TestCase
{

    /** @var i18n */
    private $label;

    /** @var i18n */
    private $description;

    /** @var array */
    private $enum;

    /** @var string */
    private $default;

    /** @var bool */
    private $required;

    /** @var EnumDefinition */
    private $enumDefinition;

    /**
     * @throws Exception
     */
    public function setUp()
    {
        parent::setUp();

        $this->label = i18n::instance([
            new Lang('en', 'Month'),
            new Lang('ru', 'Месяц'),
        ]);

        $this->description = i18n::instance([
            new Lang('en', 'Description'),
            new Lang('ru', 'Описание'),
        ]);

        $this->enum = [
            'jan' => i18n::instance([
                new Lang('en', 'January'),
                new Lang('ru', 'Январь'),
            ]),
            'feb' => i18n::instance([
                new Lang('en', 'February'),
                new Lang('ru', 'Февраль'),
            ]),
        ];

        $this->default = 'Test value for default param';
        $this->required = true;

        $this->enumDefinition = new EnumDefinition(
            $this->label,
            $this->description,
            $this->enum,
            $this->default,
            $this->required
        );
    }

    public function testToArray()
    {
        $expected = [
            'name' => 'Field name',
            'definition' => 'enum',
            'label' => $this->label->toArray(),
            'description' => $this->description->toArray(),
            'default' => $this->default,
            'required' => $this->required,
            'enum' => [
                'jan' => $this->enum['jan']->toArray(),
                'feb' => $this->enum['feb']->toArray(),
            ],
        ];

        $this->assertEquals($expected, $this->enumDefinition->toArray('Field name'));
    }

    public function testDefinition()
    {
        $this->assertEquals('enum', $this->enumDefinition->definition());
    }

    /**
     * @dataProvider dataProviderForValidate
     * @param bool $required
     * @param $value
     * @param bool $expected
     * @throws Exception
     */
    public function testValidateValue(bool $required, $value, bool $expected)
    {
        $definition = new EnumDefinition(
            $this->label,
            $this->description,
            $this->enum,
            $this->default,
            $required
        );

        $this->assertEquals($expected, $definition->validateValue($value));
    }

    public function dataProviderForValidate()
    {
        return [
            [
                'required' => true,
                'value' => null,
                'expected' => false,
            ],
            [
                'required' => true,
                'value' => 1,
                'expected' => false,
            ],
            [
                'required' => true,
                'value' => 'feb',
                'expected' => true,
            ],
            [
                'required' => true,
                'value' => 'sen',
                'expected' => false,
            ],
            [
                'required' => false,
                'value' => 'jan',
                'expected' => true,
            ],
        ];
    }

}
