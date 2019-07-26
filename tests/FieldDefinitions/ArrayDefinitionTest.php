<?php

namespace Leadvertex\Plugin\Components\Form\FieldDefinitions;


use Exception;
use Leadvertex\Plugin\Components\Form\I18n;
use Leadvertex\Plugin\Components\I18n\I18nInterface;
use PHPUnit\Framework\TestCase;
use TypeError;

class ArrayDefinitionTest extends TestCase
{

    /** @var I18nInterface */
    private $label;

    /** @var I18nInterface */
    private $description;

    /** @var mixed */
    private $default;

    /** @var bool */
    private $required;

    /** @var ArrayDefinition */
    private $arrayDefinition;

    /** @var I18nInterface[] */
    private $enum;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->label = new I18n('Organization name', 'Название организации');
        $this->description = new I18n('Description', 'Описание');
        $this->default = [];
        $this->required = true;
        $this->enum = [
            'jan' => new I18n('January', 'Январь'),
            'feb' => new I18n('February', 'Февраль'),
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
            'label' => $this->label->get(),
            'description' => $this->description->get(),
            'default' => $this->default,
            'required' => $this->required,
            'enum' => [
                'jan' => [
                    'value' => 'jan',
                    'label' => $this->enum['jan']->get()
                ],
                'feb' => [
                    'value' => 'feb',
                    'label' => $this->enum['feb']->get()
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
