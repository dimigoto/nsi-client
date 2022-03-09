<?php

declare(strict_types=1);

namespace Nsi\models;

use SimpleXMLElement;

class EducationKind extends NsiModel
{
    public string $id;
    public string $code;
    public string $name;

    /**
     * @inheritDoc
     */
    public static function getEntityName(): string
    {
        return 'EducationKind';
    }

    /**
     * @inheritDoc
     */
    public static function fromSimpleXMLElement(SimpleXMLElement $element): NsiModel
    {
        $result = parent::fromSimpleXMLElement($element);

        $result->id = (string)$element->ID;
        $result->code = (string)$element->EducationKindID;
        $result->name = (string)$element->EducationKindName;

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
                'EducationKindID' => $this->code,
                'EducationKindName' => $this->name,
            ]
        ];
    }
}
