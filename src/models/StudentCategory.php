<?php

declare(strict_types=1);

namespace Nsi\models;

use SimpleXMLElement;

class StudentCategory extends NsiModel
{
    public string $id;
    public string $code;
    public string $name;

    /**
     * @inheritDoc
     */
    public static function getEntityName(): string
    {
        return 'StudentCategory';
    }

    /**
     * @inheritDoc
     */
    public static function fromSimpleXMLElement(SimpleXMLElement $element): NsiModel
    {
        $result = parent::fromSimpleXMLElement($element);

        $result->id = (string)$element->ID;
        $result->code = (string)$element->StudentCategoryID;
        $result->name = (string)$element->StudentCategoryName;

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
                'StudentCategoryID' => $this->code,
                'StudentCategoryName' => $this->name
            ]
        ];
    }
}
