<?php

declare(strict_types=1);

namespace Nsi\models;

use SimpleXMLElement;

class AcademicGroup extends NsiModel
{
    public string $id;
    public string $code;
    public string $name;
    public string $number;
    public bool $isArchive;
    public string $archiveDate;
    public string $yearBegin;
    public string $creationDate;
    public string $yearEnd;
    public ?EducationProgram $educationProgram = null;
    public ?Course $course = null;

    /**
     * @inheritDoc
     */
    public static function getEntityName(): string
    {
        return 'AcademicGroup';
    }

    /**
     * @inheritDoc
     */
    public static function fromSimpleXMLElement(SimpleXMLElement $element): self
    {
        $result = parent::fromSimpleXMLElement($element);

        $result->id = (string)$element->ID;
        $result->code = (string)$element->AcademicGroupID;
        $result->name = (string)$element->AcademicGroupName;
        $result->number = (string)$element->AcademicGroupNumber;
        $result->isArchive = (string)$element->AcademicGroupArhiv === '1';
        $result->archiveDate = (string)$element->AcademicGroupArhivDate;
        $result->yearBegin = (string)$element->AcademicGroupYearBegin;
        $result->creationDate = (string)$element->AcademicGroupCreationDate;
        $result->yearEnd = (string)$element->AcademicGroupYearEnd;

        if (isset($element->EducationalProgramID->EducationalProgram)) {
            $result->educationProgram = EducationProgram::fromSimpleXMLElement(
                $element->EducationalProgramID->EducationalProgram
            );
        }

        if (isset($element->CourseID->Course)) {
            $result->course = Course::fromSimpleXMLElement($element->CourseID->Course);
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
                'AcademicGroupID' => $this->code,
                'AcademicGroupName' => $this->name,
                'AcademicGroupNumber' => $this->number,
                'AcademicGroupArhiv' => $this->isArchive ? '1' : '0',
                'AcademicGroupArhivDate' => $this->archiveDate,
                'AcademicGroupYearBegin' => $this->yearBegin,
                'AcademicGroupCreationDate' => $this->creationDate,
                'AcademicGroupYearEnd' => $this->yearEnd,
            ]
        ];

        if (isset($this->educationProgram)) {
            $result[static::getEntityName()]['EducationalProgramID'] = $this->educationProgram->toNsiDatagram();
        }

        if (isset($this->course)) {
            $result[static::getEntityName()]['CourseID'] = $this->course->toNsiDatagram();
        }

        return $result;
    }
}
