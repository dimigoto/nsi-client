<?php

declare(strict_types=1);

namespace Nsi\repository;

use Nsi\exceptions\NsiNotFoundException;
use Nsi\exceptions\NsiResponseWithErrorException;
use Nsi\models\ContactKind;
use Nsi\models\NsiModelCollection;

class ContactKindRepository extends BaseRepository
{
    /**
     * Возвращает вид контакта по идентификатору
     *
     * @param string $id
     *
     * @return ContactKind
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function findOneById(string $id): ContactKind
    {
        $request = $this->requestBuilder->find(
            ContactKind::getEntityName(),
            [
                'ID' => $id
            ]
        )
            ->buildRequest();

        $response = $this->nsiClient->send($request);

        return ContactKind::fromSimpleXMLElement($response->getResult()->ContactKind);
    }

    /**
     * Возвращает все виды контактов
     *
     * @return ContactKind[]
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function findAll(): array
    {
        $request = $this->requestBuilder->find(ContactKind::getEntityName(), [])
            ->buildRequest();

        $response = $this->nsiClient->send($request);

        return (new NsiModelCollection($response->getResult(), ContactKind::class))->asArray();
    }
}
