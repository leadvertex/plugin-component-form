<?php

namespace Leadvertex\Plugin\Components\Form\FieldDefinitions;


use Exception;
use Leadvertex\Plugin\Components\Form\I18n;
use Leadvertex\Plugin\Components\I18n\I18nInterface;
use PHPUnit\Framework\TestCase;

class IntegerDefinitionTest extends TestCase
{
    /** @var I18nInterface */
    private $label;

    /** @var I18nInterface */
    private $description;

    /** @var string */
    private $default;

    /** @var bool */
    private $required;

    /** @var StringDefinition */
    private $definition;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->label = new I18n('Your age', 'Ваш возраст');
        $this->description = new I18n('Description', 'Описание');

        $this->default = 5;
        $this->required = true;

        $this->definition = new IntegerDefinition(
            $this->label,
            $this->description,
            $this->default,
            $this->required
        );

    }

    public function testDefinition()
    {
        $this->assertEquals('integer', $this->definition->definition());
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
        $integerDefinition = new IntegerDefinition(
            $this->label,
            $this->description,
            $this->default,
            $required
        );

        $this->assertEquals($expected, $integerDefinition->validateValue($value));
    }

    /**
     * @return array
     * @throws Exception
     */
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
                'value' => '   ',
                'expected' => false,
            ],
            [
                'required' => true,
                'value' => random_int(1, 100),
                'expected' => true,
            ],
            [
                'required' => true,
                'value' => [
                    95,
                    49,
                ],
                'expected' => false,
            ],

            [
                'required' => false,
                'value' => null,
                'expected' => true,
            ],
            [
                'required' => false,
                'value' => '   ',
                'expected' => false,
            ],
            [
                'required' => false,
                'value' => random_int(1, 100),
                'expected' => true,
            ],
            [
                'required' => false,
                'value' => [
                    95,
                    49,
                ],
                'expected' => false,
            ],
        ];
    }
}
