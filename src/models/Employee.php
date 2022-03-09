<?php

declare(strict_types=1);

namespace Nsi\models;

use SimpleXMLElement;

class Employee extends NsiModel
{
    public string $id;
    public string $code;
    public string $contractType;
    public string $employmentType;
    public string $rate;
    public string $employmentDate;
    public string $dischargeDate;
    public ?Organization $organization;
    public ?Organization $organizationOPID;
    public Human $human;
    public ?Grade $grade;
    public ?Department $department;
    public ?Post $post;

    /**
     * @inheritDoc
     */
    public static function getEntityName(): string
    {
        return 'Employee';
    }

    /**
     * @inheritDoc
     */
    public static function fromSimpleXMLElement(SimpleXMLElement $element): self
    {
        $result = parent::fromSimpleXMLElement($element);

        $result->id = (string)$element->ID;
        $result->code = (string)$element->EmployeeID;
        $result->contractType = (string)$element->EmployeeContractKind;
        $result->employmentType = (string)$element->EmploymentKind;
        $result->rate = (string)$element->EmployeeRate;
        $result->employmentDate = (string)$element->EmployeeEmploymentDate;
        $result->dischargeDate = (string)$element->EmployeeDischargeDate;
        $result->human = Human::fromSimpleXMLElement($element->HumanID->Human);

        if (isset($element->OrganizationID->Organization)) {
            $result->organization = Organization::fromSimpleXMLElement($element->OrganizationID->Organization);
        }

        if (isset($element->OrganizationOPID->Organization)) {
            $result->organizationOPID = Organization::fromSimpleXMLElement($element->OrganizationOPID->Organization);
        }

        if (isset($element->EmployeeGradeID->Grade)) {
            $result->grade = Grade::fromSimpleXMLElement($element->EmployeeGradeID->Grade);
        }

        if (isset($element->EmployeeDepartmentID->Department)) {
            $result->department = Department::fromSimpleXMLElement($element->EmployeeDepartmentID->Department);
        }

        if (isset($element->EmployeePostID->Post)) {
            $result->post = Post::fromSimpleXMLElement($element->EmployeePostID->Post);
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
                'EmployeeID' => $this->code,
                'EmployeeContractKind' => $this->contractType,
                'EmploymentKind' => $this->employmentType,
                'EmployeeRate' => $this->rate,
                'EmployeeEmploymentDate' => $this->employmentDate,
                'EmployeeDischargeDate' => $this->dischargeDate,
                'HumanID' => $this->human->toNsiDatagram(),
            ]
        ];

        if (isset($this->organization)) {
            $result[static::getEntityName()]['OrganizationID'] = $this->organization->toNsiDatagram();
        }

        if (isset($this->organizationOPID)) {
            $result[static::getEntityName()]['OrganizationOPID'] = $this->organizationOPID->toNsiDatagram();
        }

        if (isset($this->grade)) {
            $result[static::getEntityName()]['EmployeeGradeID'] = $this->grade->toNsiDatagram();
        }

        if (isset($this->department)) {
            $result[static::getEntityName()]['EmployeeDepartmentID'] = $this->department->toNsiDatagram();
        }

        if (isset($this->post)) {
            $result[static::getEntityName()]['EmployeePostID'] = $this->post->toNsiDatagram();
        }

        return $result;
    }
}
