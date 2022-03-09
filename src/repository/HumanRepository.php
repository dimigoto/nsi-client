<?php

declare(strict_types=1);

namespace Nsi\repository;

use Nsi\exceptions\NsiNotFoundException;
use Nsi\exceptions\NsiResponseWithErrorException;
use Nsi\models\Human;
use Nsi\models\IdentityCard;

class HumanRepository extends BaseRepository
{
    /**
     * Возвращает физлицо по идентификатору
     *
     * @param string $id
     *
     * @return Human
     *
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function findOneById(string $id): Human
    {
        $request = $this->requestBuilder->find(
            Human::getEntityName(),
            [
                'ID' => $id
            ]
        )
            ->buildRequest();

        $response = $this->nsiClient->send($request);

        return Human::fromSimpleXMLElement($response->getResult()->Human);
    }

    /**
     * Ищет физлицо по ФИО и по данным паспорта
     *
     * @param string $lastName
     * @param string $firstName
     * @param string|null $middleName
     * @param string|null $series
     * @param string $number
     *
     * @return Human
     *
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function findOneByFullNameAndIdentityCard(
        string $lastName,
        string $firstName,
        ?string $middleName,
        ?string $series,
        string $number
    ): Human {
        $requestConditions = [
            'IdentityCardNumber' => $number,
            'HumanID' => [
                'Human' => [
                    'HumanLastName' => $lastName,
                    'HumanFirstName' => $firstName
                ]
            ]
        ];

        if (!empty($series)) {
            $requestConditions['IdentityCardSeries'] = $series;
        }

        if (!empty($middleName)) {
            $requestConditions['HumanID']['Human']['HumanMiddleName'] = $middleName;
        }

        $request = $this->requestBuilder
            ->find(IdentityCard::getEntityName(), $requestConditions)
            ->buildRequest();

        $response = $this->nsiClient->send($request);

        if (isset($response->getResult()->IdentityCard->HumanID->Human->ID)) {
            return $this->findOneById((string)$response->getResult()->IdentityCard->HumanID->Human->ID);
        }

        throw new NsiNotFoundException(
            sprintf(
                'Физлицо не найдено. Параметры запроса: %s %s %s, паспорт %s %s',
                $lastName,
                $firstName,
                $middleName ?? '',
                $series ?? '',
                $number
            )
        );
    }
}
