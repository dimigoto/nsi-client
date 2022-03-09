<?php

declare(strict_types=1);

namespace Nsi\repository;

use Nsi\exceptions\NsiNotFoundException;
use Nsi\exceptions\NsiResponseWithErrorException;
use Nsi\models\Contractor;
use Nsi\models\NsiModelCollection;

class ContractorRepository extends BaseRepository
{
    /**
     * Возвращает контрагента по идентификатору
     *
     * @param string $id
     *
     * @return Contractor
     *
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function findOneById(string $id): Contractor
    {
        $request = $this->requestBuilder->find(
            Contractor::getEntityName(),
            [
                'ID' => $id
            ]
        )
            ->buildRequest();

        $response = $this->nsiClient->send($request);

        return Contractor::fromSimpleXMLElement($response->getResult()->Contractor);
    }

    /**
     * Возвращает список контрагентов конкретного физлица
     *
     * @param string $id
     *
     * @return Contractor[]
     *
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function findAllByHumanId(string $id): array
    {
        $request = $this->requestBuilder->find(
            Contractor::getEntityName(),
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

        return (new NsiModelCollection($response->getResult(), Contractor::class))->asArray();
    }
}
