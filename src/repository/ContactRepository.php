<?php

declare(strict_types=1);

namespace Nsi\repository;

use Nsi\exceptions\NsiNotFoundException;
use Nsi\exceptions\NsiResponseWithErrorException;
use Nsi\models\Contact;
use Nsi\models\NsiModelCollection;

class ContactRepository extends BaseRepository
{
    /**
     * Возвращает контакт по идентификатору
     *
     * @param string $id
     *
     * @return Contact
     *
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function findOneById(string $id): Contact
    {
        $request = $this->requestBuilder->find(
            Contact::getEntityName(),
            [
                'ID' => $id
            ]
        )
            ->buildRequest();

        $response = $this->nsiClient->send($request);

        return Contact::fromSimpleXMLElement($response->getResult()->Contact);
    }

    /**
     * Возвращает список контактов конкретного физлица
     *
     * @param string $id
     *
     * @return Contact[]
     *
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function findAllByHumanId(string $id): array
    {
        $request = $this->requestBuilder->find(
            Contact::getEntityName(),
            [
                'HumanID' => [
                    'Human' => [
                        'ID' => $id
                    ]
                ]
            ]
        )
            ->buildRequest();

        $response = $this->nsiClient->send($request);

        return (new NsiModelCollection($response->getResult(), Contact::class))->asArray();
    }
}
