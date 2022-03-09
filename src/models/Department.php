<?php

declare(strict_types=1);

namespace Nsi\models;

use SimpleXMLElement;

class Department extends NsiModel
{
    public string $id;
    public string $code;
    public string $OKATO;
    public string $KPP;
    public string $name;
    public bool $isArchive;
    public ?Human $head;
    public ?Organization $organization;
    public ?Department $parent;


    /**
     * @inheritDoc
     */
    public static function getEntityName(): string
    {
        return 'Department';
    }

    /**
     * @inheritDoc
     */
    public static function fromSimpleXMLElement(SimpleXMLElement $element): self
    {
        $result = parent::fromSimpleXMLElement($element);

        $result->id = (string)$element->ID;
        $result->code = (string)$element->DepartmentID;
        $result->OKATO = (string)$element->DepartmentOKATOCode;
        $result->KPP = (string)$element->DepartmentKPP;
        $result->name = (string)$element->DepartmentName;
        $result->isArchive = $element->IsArchive === '1';

        if (isset($element->DepartmentHeader->Human)) {
            $result->head = Human::fromSimpleXMLElement($element->DepartmentHeader->Human);
        }

        if (isset($element->OrganizationID->Organization)) {
            $result->organization = Organization::fromSimpleXMLElement($element->OrganizationID->Organization);
        }

        if (isset($element->DepartmentUpper->Department)) {
            $result->parent = self::fromSimpleXMLElement($element->DepartmentUpper->Department);
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
                'DepartmentID' => $this->code,
                'DepartmentOKATOCode' => $this->OKATO,
                'DepartmentKPP' => $this->KPP,
                'DepartmentName' => $this->name,
                'IsArchive' => $this->isArchive ? '1' : '0',
            ]
        ];

        if (isset($this->head)) {
            $result[static::getEntityName()]['DepartmentHeader'] = $this->head->toNsiDatagram();
        }

        if (isset($this->organization)) {
            $result[static::getEntityName()]['OrganizationID'] = $this->organization->toNsiDatagram();
        }

        if (isset($this->parent)) {
            $result[static::getEntityName()]['DepartmentUpper'] = $this->parent->toNsiDatagram();
        }

        return $result;
    }
}
