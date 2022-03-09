<?php

declare(strict_types=1);

namespace Nsi\models;

use SimpleXMLElement;

class CompensationType extends NsiModel
{
    public string $id;
    public string $code;
    public string $nameShort;
    public string $name;
    public string $group;

    /**
     * @inheritDoc
     */
    public static function getEntityName(): string
    {
        return 'CompensationType';
    }

    /**
     * @inheritDoc
     */
    public static function fromSimpleXMLElement(SimpleXMLElement $element): self
    {
        $result = parent::fromSimpleXMLElement($element);

        $result->id = (string)$element->ID;
        $result->code = (string)$element->CompensationTypeID;
        $result->nameShort = (string)$element->CompensationTypeNameShort;
        $result->name = (string)$element->CompensationTypeName;
        $result->group = (string)$element->CompensationTypeGroup;


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
                'CompensationTypeID' => $this->code,
                'CompensationTypeNameShort' => $this->nameShort,
                'CompensationTypeName' => $this->name,
                'CompensationTypeGroup' => $this->group
            ]
        ];
    }
}
