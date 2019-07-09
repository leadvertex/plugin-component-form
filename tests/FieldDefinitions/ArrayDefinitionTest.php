<?php

namespace Leadvertex\Plugin\Scheme\FieldDefinitions;


use Exception;
use Leadvertex\Plugin\Scheme\Components\Lang;
use Leadvertex\Plugin\Scheme\Components\i18n;
use PHPUnit\Framework\TestCase;
use TypeError;

class ArrayDefinitionTest extends TestCase
{

    /** @var i18n */
    private $label;

    /** @var i18n */
    private $description;

    /** @var mixed */
    private $default;

    /** @var bool */
    private $required;

    /** @var ArrayDefinition */
    private $arrayDefinition;

    /** @var i18n[] */
    private $enum;

    /**
     * @throws Exception
     */
    public function setUp()
    {
        parent::setUp();

        $this->label = i18n::instance([
            new Lang('en', 'Organization name'),
            new Lang('ru', 'Название организации'),
        ]);

        $this->description = i18n::instance([
            new Lang('en', 'Description'),
            new Lang('ru', 'Описание'),
        ]);

        $this->default = [];

        $this->required = true;

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

        $this->arrayDefinition = new ArrayDefinition(
            $this->label,
            $this->description,
            $this->enum,
            $this->default,
            $this->required
        );
    }

    /**
     * @throws Exception
     */
    public function testInvalidEnum()
    {
        $this->expectException(TypeError::class);
        $enum = [
            'enum',
            ['invalid text for Enum'],
        ];

        $this->arrayDefinition = new ArrayDefinition(
            $this->label,
            $this->description,
            $enum,
            $this->default,
            $this->required
        );
    }

    public function testDefinition()
    {
        $this->assertEquals('array', $this->arrayDefinition->definition());
    }

    /**
     * @dataProvider dataProviderForValidate
     * @param bool $required
     * @param array $value
     * @param bool $expected
     * @throws Exception
     */
    public function testValidateValue(bool $required, $value, bool $expected)
    {
        $textDefinition = new ArrayDefinition(
            $this->label,
            $this->description,
            $this->enum,
            $this->default,
            $required
        );

        $this->assertEquals($expected, $textDefinition->validateValue($value));
    }

    public function dataProviderForValidate()
    {
        $data = [
            [
                'required' => true,
                'value' => [],
                'expected' => false,
            ],
            [
                'required' => true,
                'value' => null,
                'expected' => false,
            ],
            [
                'required' => true,
                'value' => [
                    ['test value in array'],
                    ['two'],
                ],
                'expected' => false,
            ],
            [
                'required' => true,
                'value' => [''],
                'expected' => false,
            ],

            [
                'required' => false,
                'value' => [1],
                'expected' => false,
            ],
            [
                'required' => false,
                'value' => [
                    'jan',
                    'feb',
                ],
                'expected' => true,
            ],
        ];

        $result = [];
        foreach ($data as $item) {
            $result[json_encode($item['value'])] = $item;
        }
        return $result;
    }

    public function testToArray()
    {
        $expected = [
            'name' => 'Field name',
            'definition' => 'array',
            'label' => $this->label->toArray(),
            'description' => $this->description->toArray(),
            'default' => $this->default,
            'required' => $this->required,
            'enum' => [
                'jan' => [
                    'value' => 'jan',
                    'label' => $this->enum['jan']->toArray()
                ],
                'feb' => [
                    'value' => 'feb',
                    'label' => $this->enum['feb']->toArray()
                ],
            ],
        ];

        $this->assertEquals($expected, $this->arrayDefinition->toArray('Field name'));
    }

    public function testGetEnum()
    {
        $this->assertEquals($this->enum, $this->arrayDefinition->getEnum());
    }
}
