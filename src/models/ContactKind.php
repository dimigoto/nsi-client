<?php

declare(strict_types=1);

namespace Nsi\models;

use SimpleXMLElement;

class ContactKind extends NsiModel
{
    public string $id;
    public string $code;
    public string $name;
    public string $type;
    public string $object;

    /**
     * @inheritDoc
     */
    public static function getEntityName(): string
    {
        return 'ContactKind';
    }

    /**
     * @inheritDoc
     */
    public static function fromSimpleXMLElement(SimpleXMLElement $element): self
    {
        $result = parent::fromSimpleXMLElement($element);

        $result->id = (string)$element->ID;
        $result->code = (string)$element->ContactKindID;
        $result->name = (string)$element->ContactKindName;
        $result->type = (string)$element->ContactKindType;
        $result->object = (string)$element->ContactKindObject;

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
                'ContactKindID' => $this->code,
                'ContactKindName' => $this->name,
                'ContactKindType' => $this->type,
                'ContactKindObject' => $this->object
            ]
        ];
    }
}
