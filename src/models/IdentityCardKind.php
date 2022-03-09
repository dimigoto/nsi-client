<?php

declare(strict_types=1);

namespace Nsi\models;

use SimpleXMLElement;

class IdentityCardKind extends NsiModel
{
    public string $id;
    public string $code;
    public string $name;
    public string $IFNS;
    public string $PFR;

    /**
     * @inheritDoc
     */
    public static function getEntityName(): string
    {
        return 'IdentityCardKind';
    }

    /**
     * @inheritDoc
     */
    public static function fromSimpleXMLElement(SimpleXMLElement $element): self
    {
        $result = parent::fromSimpleXMLElement($element);

        $result->id = (string)$element->ID;
        $result->code = (string)$element->IdentityCardKindID;
        $result->name = (string)$element->IdentityCardTypeName;
        $result->IFNS = (string)$element->IdentityCardTypeIFNS;
        $result->PFR = (string)$element->IdentityCardTypePFR;

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
                'IdentityCardKindID' => $this->code,
                'IdentityCardTypeName' => $this->name,
                'IdentityCardTypeIFNS' => $this->IFNS,
                'IdentityCardTypePFR' => $this->PFR,
            ]
        ];
    }
}
