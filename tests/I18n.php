<?php
/**
 * Created for plugin-form
 * Datetime: 25.07.2019 14:15
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Components\Form;


use Leadvertex\Plugin\Components\I18n\I18nInterface;

class I18n implements I18nInterface
{

    /** @var array */
    private $translations;

    public function __construct(string $en_US, string $ru_RU)
    {
        $this->translations = [
            self::en_US => [
                'lang' => self::en_US,
                'text' => $en_US,
            ],
            self::ru_RU => [
                'lang' => self::ru_RU,
                'text' => $ru_RU,
            ],
        ];
    }


    public function get(): array
    {
        return $this->translations;
    }

    public static function getLanguages(): array
    {
        return [self::en_US, self::ru_RU];
    }
}