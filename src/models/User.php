<?php

declare(strict_types=1);

namespace Nsi\models;

use Nsi\interfaces\NsiModelDTOInterface;
use SimpleXMLElement;

/**
 * Class User. Модель пользователя - собираемая модель, конкретной сущности в НСИ нет. Содержит в себе ссылки на
 * сущности связанные с конкретным пользователем.
 */
class User implements NsiModelDTOInterface
{
    public Human $human;

    /** @var Student[] */
    public array $students;

    /** @var Employee[] */
    public array $employers;

    /** @var IdentityCard[] */
    public array $identityCards;

    /** @var Contractor[] */
    public array $contractors;

    /** @var Contact[] */
    public array $contacts;

    /**
     * @param SimpleXMLElement $element
     *
     * @return static
     */
    public static function fromSimpleXMLElement(SimpleXMLElement $element): self
    {
        $result = new static();

        $result->human = Human::fromSimpleXMLElement($element->Human);

        if (isset($element->IdentityCard)) {
            $result->identityCards = (
            new NsiModelCollection(
                $element->IdentityCard,
                IdentityCard::class
            ))->asArray();
        }

        if (isset($element->Student)) {
            $result->students = (
            new NsiModelCollection(
                $element->Student,
                Student::class
            ))->asArray();
        }

        if (isset($element->Employee)) {
            $result->employers = (
            new NsiModelCollection(
                $element->Employee,
                Employee::class
            ))->asArray();
        }

        if (isset($element->Contractor)) {
            $result->contractors = (
            new NsiModelCollection(
                $element->Contractor,
                Contractor::class
            ))->asArray();
        }

        if (isset($element->Contact)) {
            $result->contacts = (
            new NsiModelCollection(
                $element->Contact,
                Contact::class
            ))->asArray();
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function toNsiDatagram(): array
    {
        return [
        ];
    }
}
