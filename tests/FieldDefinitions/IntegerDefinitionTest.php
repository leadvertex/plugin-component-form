<?php

namespace Leadvertex\Plugin\Scheme\FieldDefinitions;


use Exception;
use Leadvertex\Plugin\Scheme\Components\Lang;
use Leadvertex\Plugin\Scheme\Components\i18n;
use PHPUnit\Framework\TestCase;

class IntegerDefinitionTest extends TestCase
{
    /** @var i18n */
    private $label;

    /** @var i18n */
    private $description;

    /** @var string */
    private $default;

    /** @var bool */
    private $required;

    /** @var StringDefinition */
    private $integerDefinition;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->label = i18n::instance([
            new Lang('en', 'Your age'),
            new Lang('ru', 'Ваш возраст'),
        ]);

        $this->description = i18n::instance([
            new Lang('en', 'Description'),
            new Lang('ru', 'Описание'),
        ]);

        $this->default = 5;
        $this->required = true;

        $this->integerDefinition = new IntegerDefinition(
            $this->label,
            $this->description,
            $this->default,
            $this->required
        );

    }

    public function testDefinition()
    {
        $this->assertEquals('integer', $this->integerDefinition->definition());
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
