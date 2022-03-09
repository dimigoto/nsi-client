<?php

declare(strict_types=1);

namespace Nsi\models;

use SimpleXMLElement;

class Course extends NsiModel
{
    public string $id;
    public string $code;
    public string $number;
    public string $name;

    /**
     * @inheritDoc
     */
    public static function getEntityName(): string
    {
        return 'Course';
    }

    /**
     * @inheritDoc
     */
    public static function fromSimpleXMLElement(SimpleXMLElement $element): NsiModel
    {
        $result = parent::fromSimpleXMLElement($element);

        $result->id = (string)$element->ID;
        $result->code = (string)$element->CourseID;
        $result->number = (string)$element->CourseNumber;
        $result->name = (string)$element->CourseName;

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function toNsiDatagram(): array
    {
        return [
            static::getEntityName() => [
                'ID'=> $this->id,
                'CourseID' => $this->code,
                'CourseNumber' => $this->number,
                'CourseName' => $this->name,
            ]
        ];
    }
}
