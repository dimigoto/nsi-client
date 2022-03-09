<?php

declare(strict_types=1);

namespace Nsi\models;

use SimpleXMLElement;

class Organization extends NsiModel
{
    public string $id;
    public string $code;
    public string $name;
    public string $nameFSS;
    public string $nameFull;
    public string $nameShort;
    public string $prefix;
    public string $INN;
    public string $IFNS;
    public string $OPF;
    public string $KFS;
    public string $OKATO;
    public string $OKVED;
    public string $OKPO;
    public string $OKONH;
    public string $PFR;
    public string $KPP;
    public string $IMNS;
    public string $OKOPF;
    public string $OGRN;
    public string $regPFR;
    public string $regFSS;


    /**
     * @inheritDoc
     */
    public static function getEntityName(): string
    {
        return 'Organization';
    }

    /**
     * @inheritDoc
     */
    public static function fromSimpleXMLElement(SimpleXMLElement $element): self
    {
        $result = parent::fromSimpleXMLElement($element);

        $result->id = (string)$element->ID;
        $result->code = (string)$element->OrganizationID;
        $result->name = (string)$element->OrganizationName;
        $result->nameFSS = (string)$element->OrganizationNameFSS;
        $result->nameFull = (string)$element->OrganizationNameFull;
        $result->nameShort = (string)$element->OrganizationNameShort;
        $result->prefix = (string)$element->OrganizationPrefix;
        $result->INN = (string)$element->OrganizationINN;
        $result->IFNS = (string)$element->OrganizationIFNS;
        $result->OPF = (string)$element->OrganizationOPF;
        $result->KFS = (string)$element->OrganizationKFS;
        $result->OKATO = (string)$element->OrganizationOKATO;
        $result->OKVED = (string)$element->OrganizationOKVED;
        $result->OKPO = (string)$element->OrganizationOKPO;
        $result->OKONH = (string)$element->OrganizationOKONH;
        $result->PFR = (string)$element->OrganizationPFR;
        $result->KPP = (string)$element->OrganizationKPP;
        $result->IMNS = (string)$element->OrganizationIMNS;
        $result->OKOPF = (string)$element->OrganizationOKOPF;
        $result->OGRN = (string)$element->OrganizationOGRN;
        $result->regPFR = (string)$element->OrganizationRegPFR;
        $result->regFSS = (string)$element->OrganizationRegFSS;

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
                'OrganizationID' => $this->code,
                'OrganizationName' => $this->name,
                'OrganizationNameFSS' => $this->nameFSS,
                'OrganizationNameFull' => $this->nameFull,
                'OrganizationNameShort' => $this->nameShort,
                'OrganizationPrefix' => $this->prefix,
                'OrganizationINN' => $this->INN,
                'OrganizationIFNS' => $this->IFNS,
                'OrganizationOPF' => $this->OPF,
                'OrganizationKFS' => $this->KFS,
                'OrganizationOKATO' => $this->OKATO,
                'OrganizationOKVED' => $this->OKVED,
                'OrganizationOKPO' => $this->OKPO,
                'OrganizationOKONH' => $this->OKONH,
                'OrganizationPFR' => $this->PFR,
                'OrganizationKPP' => $this->KPP,
                'OrganizationIMNS' => $this->IMNS,
                'OrganizationOKOPF' => $this->OKOPF,
                'OrganizationOGRN' => $this->OGRN,
                'OrganizationRegPFR' => $this->regPFR,
                'OrganizationRegFSS' => $this->regFSS,
            ]
        ];
    }
}
