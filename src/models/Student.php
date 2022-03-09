<?php

declare(strict_types=1);

namespace Nsi\models;

use SimpleXMLElement;

class Student extends NsiModel
{
    public string $id;
    public string $gradebookNumber;
    public string $entranceYear;
    public bool $isArchive;
    public string $privacyNumber;
    public Human $human;
    public ?AcademicGroup $academicGroup = null;
    public ?EducationProgram $educationProgram = null;
    public ?CompensationType $compensationType = null;
    public ?StudentStatus $studentStatus = null;
    public ?Course $course = null;
    public ?StudentCategory $studentCategory = null;

    /**
     * @inheritDoc
     */
    public static function getEntityName(): string
    {
        return 'Student';
    }

    /**
     * @inheritDoc
     */
    public static function fromSimpleXMLElement(SimpleXMLElement $element): self
    {
        $result = parent::fromSimpleXMLElement($element);

        $result->id = (string)$element->ID;
        $result->gradebookNumber = (string)$element->StudentBookN;
        $result->entranceYear = (string)$element->StudentEntranceYear;
        $result->isArchive = (string)$element->StudentArhive !== '0';
        $result->privacyNumber = (string)$element->StudentPrivacyN;
        $result->human = Human::fromSimpleXMLElement($element->HumanID->Human);

        if (isset($element->AcademicGroupID->AcademicGroup)) {
            $result->academicGroup = AcademicGroup::fromSimpleXMLElement($element->AcademicGroupID->AcademicGroup);
        }

        if (isset($element->EducationalProgramID->EducationalProgram)) {
            $result->educationProgram = EducationProgram::fromSimpleXMLElement(
                $element->EducationalProgramID->EducationalProgram
            );
        }

        if (isset($element->CompensationTypeID->CompensationType)) {
            $result->compensationType = CompensationType::fromSimpleXMLElement(
                $element->CompensationTypeID->CompensationType
            );
        }

        if (isset($element->StudentStatusID->StudentStatus)) {
            $result->studentStatus = StudentStatus::fromSimpleXMLElement($element->StudentStatusID->StudentStatus);
        }

        if (isset($element->CourseID->Course)) {
            $result->course = Course::fromSimpleXMLElement($element->CourseID->Course);
        }

        if (isset($element->StudentCategoryID->StudentCategory)) {
            $result->studentCategory = StudentCategory::fromSimpleXMLElement(
                $element->StudentCategoryID->StudentCategory
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
                'StudentBookN' => $this->gradebookNumber,
                'StudentEntranceYear' => $this->entranceYear,
                'StudentArhive' => $this->isArchive ? '1' : '0',
                'StudentPrivacyN' => $this->privacyNumber,
                'HumanID' => $this->human->toNsiDatagram(),
            ]
        ];

        if (isset($this->academicGroup)) {
            $result[static::getEntityName()]['AcademicGroupID'] = $this->academicGroup->toNsiDatagram();
        }

        if (isset($this->educationProgram)) {
            $result[static::getEntityName()]['EducationalProgramID'] = $this->educationProgram->toNsiDatagram();
        }

        if (isset($this->compensationType)) {
            $result[static::getEntityName()]['CompensationTypeID'] = $this->compensationType->toNsiDatagram();
        }

        if (isset($this->studentStatus)) {
            $result[static::getEntityName()]['StudentStatusID'] = $this->studentStatus->toNsiDatagram();
        }

        if (isset($this->course)) {
            $result[static::getEntityName()]['CourseID'] = $this->course->toNsiDatagram();
        }

        if (isset($this->studentCategory)) {
            $result[static::getEntityName()]['StudentCategoryID'] = $this->studentCategory->toNsiDatagram();
        }

        return $result;
    }
}
