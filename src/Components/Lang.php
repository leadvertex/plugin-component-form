<?php
/**
 * Created for plugin-form
 * Datetime: 08.07.2019 15:30
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Scheme\Components;


class Lang
{

    /**
     * @var string
     */
    private $language;
    /**
     * @var string
     */
    private $text;

    public function __construct(string $language, string $text)
    {
        $this->language = $language;
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

}