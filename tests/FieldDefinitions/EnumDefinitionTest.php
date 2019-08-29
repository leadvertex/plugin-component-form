<?php

namespace Leadvertex\Plugin\Components\Form\FieldDefinitions;


use Exception;
use Leadvertex\Plugin\Components\Form\I18n;
use Leadvertex\Plugin\Components\I18n\I18nInterface;
use PHPUnit\Framework\TestCase;

class EnumDefinitionTest extends TestCase
{

    /** @var I18nInterface */
    private $label;

    /** @var I18nInterface */
    private $description;

    /** @var array */
    private $enum;

    /** @var string */
    private $default;

    /** @var bool */
    private $required;

    /** @var EnumDefinition */
    private $definition;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->label = new I18n('Month', 'Месяц');
        $this->description = new I18n('Description', 'Описание');
        $this->default = [];
        $this->required = true;
        $this->enum = [
            'jan' => new I18n('January', 'Январь'),
            'feb' => new I18n('February', 'Февраль'),
        ];

        $this->default = 'Test value for default param';
        $this->required = true;

        $this->definition = new EnumDefinition(
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

        $this->assertEquals($expected, $this->definition->toArray('Field name'));
    }

    public function testDefinition()
    {
        $this->assertEquals('enum', $this->definition->definition());
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
