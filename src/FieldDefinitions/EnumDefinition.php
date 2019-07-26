<?php
/**
 * Created for plugin-form.
 * Datetime: 02.07.2018 16:07
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Components\Form\FieldDefinitions;


use Exception;
use Leadvertex\Plugin\Components\I18n\I18nInterface;

class EnumDefinition extends FieldDefinition
{

    use GuardEnumTrait;

    protected $enum;

    /**
     * ConfigDefinition constructor.
     * @param I18nInterface $label
     * @param I18nInterface $description
     * @param I18nInterface[] $enum witch represent value => caption dropdown in different languages
     * array(
     *  '01' => new MultiLang('en' => 'January', 'ru' => 'Январь'),
     *  '02' => new MultiLang('en' => 'February', 'ru' => 'Февраль'),
     * )
     * @param string|int|float|bool|null $default value
     * @param bool $required is this field required
     * @throws Exception
     */
    public function __construct(I18nInterface $label, I18nInterface $description, array $enum, $default, bool $required)
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
        return 'enum';
    }

    public function toArray(string $name): array
    {
        $array = parent::toArray($name);
        foreach ($this->enum as $value => $I18nInterface) {
            $array['enum'][$value] = [
                'value' => $value,
                'label' => $I18nInterface->get(),
            ];
        }
        return $array;
    }

    /**
     * @param string|int|float|null $value
     * @return bool
     */
    public function validateValue($value): bool
    {
        if ($this->isRequired() && is_null($value)) {
            return false;
        }

        return isset($this->enum[$value]);
    }
}