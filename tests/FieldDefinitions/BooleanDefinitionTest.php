<?php

namespace Leadvertex\Plugin\Scheme\FieldDefinitions;


use Exception;
use Leadvertex\Plugin\Scheme\Components\Lang;
use Leadvertex\Plugin\Scheme\Components\i18n;
use PHPUnit\Framework\TestCase;

class BooleanDefinitionTest extends TestCase
{

    /** @var BooleanDefinition */
    private $checkboxDefinition;

    /** @var i18n */
    private $label;

    /** @var i18n */
    private $description;

    /** @var string */
    private $default;

    /** @var bool */
    private $required;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->label = i18n::instance([
            new Lang('en', 'Use field'),
            new Lang('ru', 'Использовать поле'),
        ]);

        $this->description = i18n::instance([
            new Lang('en', 'Description'),
            new Lang('ru', 'Описание'),
        ]);

        $this->default = 'Test value for default param';
        $this->required = true;

        $this->checkboxDefinition = new BooleanDefinition(
            $this->label,
            $this->description,
            $this->default,
            $this->required
        );
    }

    public function testDefinition()
    {
        $this->assertEquals('boolean', $this->checkboxDefinition->definition());
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
        $definition = new BooleanDefinition(
            $this->label,
            $this->description,
            $this->default,
            $required
        );

        $this->assertEquals($expected, $definition->validateValue($value));
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
                'value' => false,
                'expected' => false,
            ],
            [
                'required' => true,
                'value' => true,
                'expected' => true,
            ],

            [
                'required' => false,
                'value' => false,
                'expected' => true,
            ],
            [
                'required' => false,
                'value' => null,
                'expected' => false,
            ],
            [
                'required' => false,
                'value' => random_int(1, 100),
                'expected' => false,
            ],
            [
                'required' => false,
                'value' => [],
                'expected' => false,
            ],
            [
                'required' => false,
                'value' => 'string',
                'expected' => false,
            ],
        ];
    }

    public function testGetDefaultValue()
    {
        $this->assertEquals($this->default, $this->checkboxDefinition->getDefaultValue());
    }

    public function testIsRequired()
    {
        $this->assertEquals($this->required, $this->checkboxDefinition->isRequired());
    }
}
