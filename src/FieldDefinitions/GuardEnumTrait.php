<?php
/**
 * Created for plugin-form
 * Datetime: 08.07.2019 17:10
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Form\FieldDefinitions;


use Leadvertex\Plugin\I18n\I18nInterface;
use TypeError;

trait GuardEnumTrait
{

    private function guardEnumI18n(array $translations)
    {
        foreach ($translations as $translation) {
            if (!($translation instanceof I18nInterface)) {
                throw new TypeError('Every enum label should be instance of ' . I18nInterface::class);
            }
        }
    }

}