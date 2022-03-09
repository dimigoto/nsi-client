<?php

declare(strict_types=1);

namespace Nsi\models;

use SimpleXMLElement;

class StudentStatus extends NsiModel
{
    public string $id;
    public string $code;
    public string $nameShort;
    public string $name;
    public bool $isArchive;
    public bool $isUseInSystem;
    public string $priority;

    /**
     * @inheritDoc
     */
    public static function getEntityName(): string
    {
        return 'StudentStatus';
    }

    /**
     * @inheritDoc
     */
    public static function fromSimpleXMLElement(SimpleXMLElement $element): self
    {
        $result = parent::fromSimpleXMLElement($element);

        $result->id = (string)$element->ID;
        $result->code = (string)$element->StudentStatusID;
        $result->nameShort = (string)$element->StudentStatusNameShort;
        $result->name = (string)$element->StudentStatusName;
        $result->isArchive = (string)$element->StudentStatusActive !== '1';
        $result->isUseInSystem = (string)$element->StudentStatusUsedinSystem !== '1';
        $result->priority = (string)$element->StudentStatusPriority;

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
                'StudentStatusID' => $this->code,
                'StudentStatusNameShort' => $this->nameShort,
                'StudentStatusName' => $this->name,
                'StudentStatusActive' => $this->isArchive ? '0' : '1',
                'StudentStatusUsedinSystem' => $this->isUseInSystem ? '1' : '0',
                'StudentStatusPriority' => $this->priority,
            ]
        ];
    }
}
