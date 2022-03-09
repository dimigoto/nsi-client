<?php

declare(strict_types=1);

namespace Nsi\models;

use SimpleXMLElement;

class Post extends NsiModel
{
    public string $id;
    public string $code;
    public string $name;
    public bool $isAUP;
    public string $statisticalServiceCategory;
    public bool $isFlyingCrew;

    /**
     * @inheritDoc
     */
    public static function getEntityName(): string
    {
        return 'Post';
    }

    /**
     * @inheritDoc
     */
    public static function fromSimpleXMLElement(SimpleXMLElement $element): self
    {
        $result = parent::fromSimpleXMLElement($element);

        $result->id = (string)$element->ID;
        $result->code = (string)$element->PostID;
        $result->name = (string)$element->PostName;
        $result->isAUP = (string)$element->PostAUP !== '0';
        $result->statisticalServiceCategory = (string)$element->PostStatisticalServiceCategory;
        $result->isFlyingCrew = (string)$element->PostFlyingCrew !== '0';

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
                'PostID' => $this->code,
                'PostName' => $this->name,
                'PostAUP' => $this->isAUP ? '1' : '0',
                'PostStatisticalServiceCategory' => $this->statisticalServiceCategory,
                'PostFlyingCrew' => $this->isFlyingCrew ? '1' : '0',
            ]
        ];
    }
}
