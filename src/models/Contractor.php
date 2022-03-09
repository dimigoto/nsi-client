<?php

declare(strict_types=1);

namespace Nsi\models;

use SimpleXMLElement;

class Contractor extends NsiModel
{
    public string $id;
    public string $code;
    public string $type;
    public string $nameFull;
    public Human $human;

    /**
     * @inheritDoc
     */
    public static function getEntityName(): string
    {
        return 'Contractor';
    }

    /**
     * @inheritDoc
     */
    public static function fromSimpleXMLElement(SimpleXMLElement $element): self
    {
        $result = parent::fromSimpleXMLElement($element);

        $result->id = (string)$element->ID;
        $result->code = (string)$element->ContractorID;
        $result->type = (string)$element->ContractorKind;
        $result->nameFull = (string)$element->ContractorNameFull;
        $result->human = Human::fromSimpleXMLElement($element->HumanID->Human);

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
                'ContractorID' => $this->code,
                'ContractorKind' => $this->type,
                'ContractorNameFull' => $this->nameFull,
                'HumanID' => $this->human->toNsiDatagram()
            ]
        ];
    }
}
