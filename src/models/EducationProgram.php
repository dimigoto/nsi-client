<?php

declare(strict_types=1);

namespace Nsi\models;

use SimpleXMLElement;

class EducationProgram extends NsiModel
{
    public string $id;
    public string $code;
    public string $name;
    public ?Department $department;
    public ?EducationForm $educationForm;

    /**
     * @inheritDoc
     */
    public static function getEntityName(): string
    {
        return 'EducationalProgram';
    }

    /**
     * @inheritDoc
     */
    public static function fromSimpleXMLElement(SimpleXMLElement $element): self
    {
        $result = parent::fromSimpleXMLElement($element);

        $result->id = (string)$element->ID;
        $result->code = (string)$element->EducationalProgramID;
        $result->name = (string)$element->EducationalProgramName;

        if (isset($element->DepartmentID->Department)) {
            $result->department = Department::fromSimpleXMLElement($element->DepartmentID->Department);
        }

        if (isset($element->EducationFormID->EducationForm)) {
            $result->educationForm = EducationForm::fromSimpleXMLElement($element->EducationFormID->EducationForm);
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
                'EducationalProgramID' => $this->code,
                'EducationalProgramName' => $this->name,
            ]
        ];

        if (isset($this->educationForm)) {
            $result[static::getEntityName()]['DepartmentID'] = $this->educationForm->toNsiDatagram();
        }

        if (isset($this->department)) {
            $result[static::getEntityName()]['EducationFormID'] = $this->department->toNsiDatagram();
        }

        return $result;
    }
}
