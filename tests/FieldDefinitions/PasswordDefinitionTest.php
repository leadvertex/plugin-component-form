<?php
/**
 * Created for plugin-scheme
 * Datetime: 17.07.2019 13:32
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Scheme\FieldDefinitions;

use Exception;
use Leadvertex\Plugin\Scheme\Components\i18n;
use Leadvertex\Plugin\Scheme\Components\Lang;
use PHPUnit\Framework\TestCase;

class PasswordDefinitionTest extends TestCase
{

    /** @var i18n */
    private $label;

    /** @var i18n */
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
    public function setUp()
    {
        parent::setUp();

        $this->label = i18n::instance([
            new Lang('en', 'Password'),
            new Lang('ru', 'Пароль'),
        ]);

        $this->description = i18n::instance([
            new Lang('en', 'Description'),
            new Lang('ru', 'Описание'),
        ]);

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
