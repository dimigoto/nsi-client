<?php

declare(strict_types=1);

namespace Nsi\models;

use SimpleXMLElement;

class Contact extends NsiModel
{
    public string $id;
    public string $type;
    public string $description;
    public string $field1;
    public string $field2;
    public string $field3;
    public string $field4;
    public string $field5;
    public string $field6;
    public string $field7;
    public string $field8;
    public string $field9;
    public string $field10;
    public string $comment;
    public bool $isDefault;
    public ?ContactKind $kind;
    public ?Human $human;

    /**
     * @inheritDoc
     */
    public static function getEntityName(): string
    {
        return 'Contact';
    }

    /**
     * @inheritDoc
     */
    public static function fromSimpleXMLElement(SimpleXMLElement $element): self
    {
        $result = parent::fromSimpleXMLElement($element);

        $result->id = (string)$element->ID;
        $result->type = (string)$element->ContactType;
        $result->description = (string)$element->ContactDescription;

        for ($i = 1; $i <= 10; $i++) {
            $propertyName = 'field' . $i;
            $elementFieldName = 'ContactField' . $i;

            $result->$propertyName = (string)$element->$elementFieldName;
        }

        $result->comment = (string)$element->ContactComment;
        $result->isDefault = $element->ContactDefault === '1';

        if (isset($element->ContactKindID->ContactKind)) {
            $result->kind = ContactKind::fromSimpleXMLElement($element->ContactKindID->ContactKind);
        }

        if (isset($element->HumanID->Human)) {
            $result->human = Human::fromSimpleXMLElement($element->HumanID->Human);
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function toNsiDatagram(): array
    {
        $result = [
            static::getEntityName() => [
                'ID' => $this->id,
                'ContactType' => $this->type,
                'ContactDescription' => $this->description,
                'ContactComment' => $this->comment,
                'ContactDefault' => $this->isDefault ? '1' : '0'
            ]
        ];

        for ($i = 1; $i <= 10; $i++) {
            $propertyName = 'field' . $i;
            $elementFieldName = 'ContactField' . $i;

            $result[static::getEntityName()][$elementFieldName] = $this->$propertyName;
        }

        if (isset($this->kind)) {
            $result[static::getEntityName()]['ContactKindID'] = $this->kind->toNsiDatagram();
        }

        if (isset($this->human)) {
            $result[static::getEntityName()]['HumanID'] = $this->human->toNsiDatagram();
        }

        return $result;
    }
}
