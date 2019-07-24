<?php
/**
 * Created for plugin-form
 * Datetime: 08.07.2019 17:10
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Scheme\FieldDefinitions;


use Leadvertex\Plugin\Scheme\Components\i18n;
use TypeError;

trait GuardEnumTrait
{

    private function guardEnumI18n(array $translations)
    {
        foreach ($translations as $translation) {
            if (!($translation instanceof i18n)) {
                throw new TypeError('Every enum label should be instance of ' . i18n::class);
            }
        }
    }

}