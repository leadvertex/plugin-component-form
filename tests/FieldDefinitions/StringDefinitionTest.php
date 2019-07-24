<?php

namespace Leadvertex\Plugin\Scheme\FieldDefinitions;


use Exception;
use Leadvertex\Plugin\Scheme\Components\Lang;
use Leadvertex\Plugin\Scheme\Components\i18n;
use PHPUnit\Framework\TestCase;

class StringDefinitionTest extends TestCase
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
    private $stringDefinition;

    /**
     * @throws Exception
     */
    protected function setUp(): void
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

        $this->default = 'Test value for default param';
        $this->required = true;

        $this->stringDefinition = new StringDefinition(
            $this->label,
            $this->description,
            $this->default,
            $this->required
        );

    }

    public function testDefinition()
    {
        $this->assertEquals('string', $this->stringDefinition->definition());
    }

    /**
     * @dataProvider dataProviderForValidate
     * @param bool $required
     * @param string $value
     * @param bool $expected
     * @throws Exception
     */
    public function testValidateValue(bool $required, $value, bool $expected)
    {
        $stringDefinition = new StringDefinition(
            $this->label,
            $this->description,
            $this->default,
            $required
        );

        $this->assertEquals($expected, $stringDefinition->validateValue($value));
    }

    public function dataProviderForValidate()
    {
        return [
            [
                'required' => true,
                'value' => '   ',
                'expected' => false,
            ],
            [
                'required' => true,
                'value' => 'notEmpty',
                'expected' => true,
            ],
            [
                'required' => true,
                'value' => 1,
                'expected' => false,
            ],
            [
                'required' => true,
                'value' => [],
                'expected' => false,
            ],

            [
                'required' => false,
                'value' => '   ',
                'expected' => true,
            ],
            [
                'required' => false,
                'value' => 'notEmpty',
                'expected' => true,
            ],
            [
                'required' => false,
                'value' => 1,
                'expected' => false,
            ],
        ];
    }
}
