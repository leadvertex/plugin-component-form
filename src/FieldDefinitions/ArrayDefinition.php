<?php
/**
 * Created for plugin-export-core.
 * Datetime: 02.07.2018 15:37
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Scheme\FieldDefinitions;


use Exception;
use Leadvertex\Plugin\Scheme\Components\i18n;

class ArrayDefinition extends FieldDefinition
{

    use GuardEnumTrait;

    /**
     * @var i18n[]
     */
    protected $enum;

    /**
     * ArrayDefinition constructor.
     * @param i18n $label
     * @param i18n $description
     * @param i18n[] $enum witch represent value => caption dropdown in different languages
     * array(
     *  'jan' => new MultiLang('en' => 'January', 'ru' => 'Январь'),
     *  'feb' => new MultiLang('en' => 'February', 'ru' => 'Февраль'),
     * )
     * @param $default
     * @param bool $required
     * @throws Exception
     */
    public function __construct(i18n $label, i18n $description, array $enum, $default, bool $required)
    {
        parent::__construct($label, $description, $default, $required);
        $this->guardEnumI18n($enum);
        $this->enum = $enum;
    }

    /**
     * @return string
     */
    public function definition(): string
    {
        return 'array';
    }

    /**
     * @param $array
     * @return bool
     */
    public function validateValue($array): bool
    {
        $isEmpty = is_null($array) || (is_array($array) && empty($array));
        if ($this->isRequired() && $isEmpty) {
            return false;
        }

        $isFlatArray = is_array($array) && (count($array) !== count($array, COUNT_RECURSIVE));
        if ($isFlatArray) {
            return false;
        }

        //Invalid values
        foreach ($array as $value) {
            if (!isset($this->enum[$value])) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return array
     */
    public function getEnum(): array
    {
        return $this->enum;
    }

    public function toArray(): array
    {
        $array = parent::toArray();
        foreach ($this->enum as $name => $i18n) {
            $array['enum'][$name] = $i18n->toArray();
        }
        return $array;
    }
}