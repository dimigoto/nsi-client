<?php

declare(strict_types=1);

namespace Nsi\models;

use SimpleXMLElement;

class Grade extends NsiModel
{
    public string $id;
    public string $code;
    public string $name;

    /**
     * @inheritDoc
     */
    public static function getEntityName(): string
    {
        return 'Grade';
    }

    /**
     * @inheritDoc
     */
    public static function fromSimpleXMLElement(SimpleXMLElement $element): self
    {
        $result = parent::fromSimpleXMLElement($element);

        $result->id = (string)$element->ID;
        $result->code = (string)$element->GradeID;
        $result->name = (string)$element->GradeName;

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
                'GradeID' => $this->code,
                'GradeName' => $this->name,
            ]
        ];
    }
}
