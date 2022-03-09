<?php

declare(strict_types=1);

namespace Nsi\models;

use SimpleXMLElement;

class Oksm extends NsiModel
{
    public string $id;
    public string $code;
    public string $nameShort;
    public string $nameFull;

    /**
     * @inheritDoc
     */
    public static function getEntityName(): string
    {
        return 'Oksm';
    }

    /**
     * @inheritDoc
     */
    public static function fromSimpleXMLElement(SimpleXMLElement $element): self
    {
        $result = parent::fromSimpleXMLElement($element);

        $result->id = (string)$element->ID;
        $result->code = (string)$element->OksmID;
        $result->nameShort = (string)$element->OksmNameShort;
        $result->nameFull = (string)$element->OksmNameFull;

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
                'OksmID' => $this->code,
                'OksmNameShort' => $this->nameShort,
                'OksmNameFull' => $this->nameFull,
            ]
        ];
    }
}
