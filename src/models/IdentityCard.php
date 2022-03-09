<?php

declare(strict_types=1);

namespace Nsi\models;

use SimpleXMLElement;

class IdentityCard extends NsiModel
{
    public string $id;
    public string $period;
    public string $series;
    public string $number;
    public string $departmentCode;
    public string $issuedBy;
    public string $issuedAt;
    public ?Human $human = null;
    public ?IdentityCardKind $documentType = null;

    /**
     * @inheritDoc
     */
    public static function getEntityName(): string
    {
        return 'IdentityCard';
    }

    /**
     * @inheritDoc
     */
    public static function fromSimpleXMLElement(SimpleXMLElement $element): self
    {
        $result = parent::fromSimpleXMLElement($element);

        $result->id = (string)$element->ID;
        $result->period = (string)$element->IdentityCardPeriod;
        $result->series = (string)$element->IdentityCardSeries;
        $result->number = (string)$element->IdentityCardNumber;
        $result->departmentCode = (string)$element->IdentityCardDepartmentCode;
        $result->issuedBy = (string)$element->IdentityCardWhoGive;
        $result->issuedAt = (string)$element->IdentityCardDateGive;

        if (isset($element->HumanID->Human)) {
            $result->human = Human::fromSimpleXMLElement($element->HumanID->Human);
        }

        if (isset($element->IdentityCardKindID->IdentityCardKind)) {
            $result->documentType = IdentityCardKind::fromSimpleXMLElement(
                $element->IdentityCardKindID->IdentityCardKind
            );
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
                'IdentityCardPeriod' => $this->period,
                'IdentityCardSeries' => $this->series,
                'IdentityCardNumber' => $this->number,
                'IdentityCardDepartmentCode' => $this->departmentCode,
                'IdentityCardWhoGive' => $this->issuedBy,
                'IdentityCardDateGive' => $this->issuedAt
            ]
        ];

        if (isset($this->human)) {
            $result[static::getEntityName()]['HumanID'] = $this->human->toNsiDatagram();
        }

        if (isset($this->documentType)) {
            $result[static::getEntityName()]['IdentityCardKindID'] = $this->documentType->toNsiDatagram();
        }

        return $result;
    }
}
