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

    public function __construct(string $en, string $ru)
    {
        $this->translations = [
            'en' => $en,
            'ru' => $ru,
        ];
    }

    /**
     * Should return array like
     * array(
     *  'en' => 'Message',
     *  'ru' => 'Сообщение',
     *  'es' => 'El mensaje',
     * )
     * with same language order in constructor. See README.md for details
     * @return array
     */
    public function get(): array
    {
        return $this->translations;
    }

    /**
     * Method should return array of used languages by alpha-2 code
     * @see https://en.wikipedia.org/wiki/ISO_639-1 with same order as
     * in constructor. See README.md for details
     * @return array, for example ['en', 'ru', 'es', ...]
     */
    public static function getLanguages(): array
    {
        return ['en', 'ru'];
    }
}