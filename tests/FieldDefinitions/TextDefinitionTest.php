<?php

namespace Leadvertex\Plugin\Components\Form\FieldDefinitions;


use Exception;
use Leadvertex\Plugin\Components\Form\I18n;
use Leadvertex\Plugin\Components\I18n\I18nInterface;
use PHPUnit\Framework\TestCase;

class TextDefinitionTest extends TestCase
{

    /** @var I18nInterface */
    private $label;

    /** @var I18nInterface */
    private $description;

    /** @var string */
    private $default;

    /** @var bool */
    private $required;

    /** @var TextDefinition */
    private $textDefinition;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->label = new I18n('Comment', 'Комментарий');
        $this->description = new I18n('Description', 'Описание');

        $this->default = 'Test value for default param';
        $this->required = true;

        $this->textDefinition = new TextDefinition(
            $this->label,
            $this->description,
            $this->default,
            $this->required
        );

    }

    public function testDefinition()
    {
        $this->assertEquals('text', $this->textDefinition->definition());
    }

}
