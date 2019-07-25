<?php
/**
 * Created for plugin-form
 * Datetime: 17.07.2019 13:32
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Form\FieldDefinitions;

use Exception;
use Leadvertex\Plugin\Form\I18n;
use Leadvertex\Plugin\I18n\I18nInterface;
use PHPUnit\Framework\TestCase;

class PasswordDefinitionTest extends TestCase
{

    /** @var I18nInterface */
    private $label;

    /** @var I18nInterface */
    private $description;

    /** @var string */
    private $default;

    /** @var bool */
    private $required;

    /** @var PasswordDefinition */
    private $definition;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->label = new I18n('Password', 'Пароль');
        $this->description = new I18n('Description', 'Описание');

        $this->default = 'qwerty';
        $this->required = true;

        $this->definition = new PasswordDefinition(
            $this->label,
            $this->description,
            $this->default,
            $this->required
        );

    }

    public function testDefinition()
    {
        $this->assertEquals('password', $this->definition->definition());
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
        $stringDefinition = new PasswordDefinition(
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
