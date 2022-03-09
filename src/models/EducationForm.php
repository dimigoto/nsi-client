<?php

declare(strict_types=1);

namespace Nsi\models;

use SimpleXMLElement;

class EducationForm extends NsiModel
{
    public string $id;
    public string $code;
    public string $name;
    public string $nameShort;

    /**
     * @inheritDoc
     */
    public static function getEntityName(): string
    {
        return 'EducationForm';
    }

    /**
     * @inheritDoc
     */
    public static function fromSimpleXMLElement(SimpleXMLElement $element): NsiModel
    {
        $result = parent::fromSimpleXMLElement($element);

        $result->id = (string)$element->ID;
        $result->code = (string)$element->EducationFormID;
        $result->name = (string)$element->EducationFormName;
        $result->nameShort = (string)$element->EducationFormNameShort;

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function toNsiDatagram(): array
    {
        return [
            static::getEntityName() => [
                'ID' => $this->id,
                'EducationFormID' => $this->code,
                'EducationFormName' => $this->name,
                'EducationFormNameShort' => $this->nameShort,
            ]
        ];
    }
}
