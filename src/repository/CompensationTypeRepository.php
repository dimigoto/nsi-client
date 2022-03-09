<?php

declare(strict_types=1);

namespace Nsi\repository;

use Nsi\exceptions\NsiNotFoundException;
use Nsi\exceptions\NsiResponseWithErrorException;
use Nsi\models\CompensationType;
use Nsi\models\NsiModelCollection;

class CompensationTypeRepository extends BaseRepository
{
    /**
     * Возвращает вид возмещения затрат по идентификатору
     *
     * @param string $id
     *
     * @return CompensationType
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function findOneById(string $id): CompensationType
    {
        $request = $this->requestBuilder->find(
            CompensationType::getEntityName(),
            [
                'ID' => $id
            ]
        )
            ->buildRequest();

        $response = $this->nsiClient->send($request);

        return CompensationType::fromSimpleXMLElement($response->getResult()->CompensationType);
    }

    /**
     * Возвращает все виды возмещения затрат
     *
     * @return CompensationType[]
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function findAll(): array
    {
        $request = $this->requestBuilder->find(CompensationType::getEntityName(), [])
            ->buildRequest();

        $response = $this->nsiClient->send($request);

        return (new NsiModelCollection($response->getResult(), CompensationType::class))->asArray();
    }
}
