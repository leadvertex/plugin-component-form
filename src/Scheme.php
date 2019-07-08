<?php
/**
 * Created for plugin-export-core
 * Datetime: 02.07.2018 16:59
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Scheme;


use Leadvertex\Plugin\Scheme\Components\i18n;
use TypeError;

class Scheme
{

    /** @var i18n  */
    protected $name;

    /** @var i18n  */
    protected $description;

    /** @var FieldGroup[] */
    protected $groups = [];

    /** @var Developer */
    private $developer;

    /**
     * Scheme constructor.
     * @param Developer $developer
     * @param i18n $name
     * @param i18n $description
     * @param FieldGroup[] $fieldGroups
     */
    public function __construct(Developer $developer, i18n $name, i18n $description, array $fieldGroups)
    {
        $this->developer = $developer;
        $this->name = $name;
        $this->description = $description;

        foreach ($fieldGroups as $groupName => $fieldsGroup) {
            if (!$fieldsGroup instanceof FieldGroup) {
                throw new TypeError('Every item of $fieldsDefinitions should be instance of ' . FieldGroup::class);
            }
            $this->groups[$groupName] = $fieldsGroup;
        }
    }

    /**
     * @return Developer
     */
    public function getDeveloper(): Developer
    {
        return $this->developer;
    }

    /**
     * Return property name in passed language. If passed language was not defined, will return name in default language
     * @return i18n
     */
    public function getName(): i18n
    {
        return $this->name;
    }

    /**
     * Return property description in passed language. If passed language was not defined, will return description in default language
     * @return i18n
     */
    public function getDescription(): i18n
    {
        return $this->description;
    }

    /**
     * @param string $name
     * @return FieldGroup
     */
    public function getGroup(string $name): FieldGroup
    {
        return $this->groups[$name];
    }

    /**
     * @return FieldGroup[]
     */
    public function getGroups(): array
    {
        return $this->groups;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = [
            'developer' => $this->developer->toArray(),
            'name' => $this->name->toArray(),
            'description' => $this->description->toArray(),
            'groups' => [],
            'languages' => i18n::getLanguageList(),
        ];

        foreach ($this->getGroups() as $groupName => $fieldDefinition) {
            $array['groups'][$groupName] = $fieldDefinition->toArray();
        }

        return $array;
    }

}