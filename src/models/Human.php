<?php

declare(strict_types=1);

namespace Nsi\models;

use SimpleXMLElement;

class Human extends NsiModel
{
    public string $id;
    public string $code;
    public string $login;
    public string $lastNameShort;
    public string $lastName;
    public string $firstName;
    public string $middleName;
    public string $birthdate;
    public string $basicEmail;
    public string $pfr;
    public string $birthPlace;
    public string $gender;
    public ?Oksm $citizenship = null;

    /**
     * @inheritDoc
     */
    public static function getEntityName(): string
    {
        return 'Human';
    }

    /**
     * @inheritDoc
     */
    public static function fromSimpleXMLElement(SimpleXMLElement $element): self
    {
        $result = parent::fromSimpleXMLElement($element);

        $result->id = (string)$element->ID;
        $result->code = (string)$element->HumanID;
        $result->login = (string)$element->HumanLogin;
        $result->lastNameShort = (string)$element->HumanLastNameShort;
        $result->lastName = (string)$element->HumanLastName;
        $result->firstName = (string)$element->HumanFirstName;
        $result->middleName = (string)$element->HumanMiddleName;
        $result->birthdate = (string)$element->HumanBirthdate;
        $result->basicEmail = (string)$element->HumanBasicEmail;
        $result->pfr = (string)$element->HumanPFR;
        $result->birthPlace = (string)$element->HumanBirthPlace;
        $result->gender = (string)$element->HumanSex;

        if (isset($element->HumanCitizenship->Oksm)) {
            $result->citizenship = Oksm::fromSimpleXMLElement($element->HumanCitizenship->Oksm);
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
                'HumanID' => $this->code,
                'HumanLogin' => $this->login,
                'HumanLastNameShort' => $this->lastNameShort,
                'HumanLastName' => $this->lastName,
                'HumanFirstName' => $this->firstName,
                'HumanMiddleName' => $this->middleName,
                'HumanBirthdate' => $this->birthdate,
                'HumanBasicEmail' => $this->basicEmail,
                'HumanPFR' => $this->pfr,
                'HumanBirthPlace' => $this->birthPlace,
                'HumanSex' => $this->gender,
            ]
        ];

        if (isset($this->citizenship)) {
            $result[static::getEntityName()]['HumanCitizenship'] = $this->citizenship->toNsiDatagram();
        }

        return $result;
    }
}
