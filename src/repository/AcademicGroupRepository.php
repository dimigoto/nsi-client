<?php

declare(strict_types=1);

namespace Nsi\repository;

use Nsi\exceptions\NsiNotFoundException;
use Nsi\exceptions\NsiResponseWithErrorException;
use Nsi\models\AcademicGroup;
use Nsi\models\NsiModelCollection;

class AcademicGroupRepository extends BaseRepository
{
    /**
     * Возвращает академическую группу по идентификатору
     *
     * @param string $id
     *
     * @return AcademicGroup
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function findOneById(string $id): AcademicGroup
    {
        $request = $this->requestBuilder->find(
            AcademicGroup::getEntityName(),
            [
                'ID' => $id
            ]
        )
            ->buildRequest();

        $response = $this->nsiClient->send($request);

        return AcademicGroup::fromSimpleXMLElement($response->getResult()->AcademicGroup);
    }

    /**
     * Возвращает все академические группы. Внимание! Запрос очень долгий, рекомендуется увеличить таймаут сокетов
     * и SoapClient
     *
     * @return AcademicGroup[]
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function findAll(): array
    {
        $request = $this->requestBuilder->find(AcademicGroup::getEntityName(), [])
            ->buildRequest();

        $response = $this->nsiClient->send($request);

        return (new NsiModelCollection($response->getResult(), AcademicGroup::class))->asArray();
    }

    /**
     * Возвращает все не архивные подразделения. Внимание! Запрос очень долгий, рекомендуется увеличить таймаут сокетов
     * и SoapClient
     *
     * @return AcademicGroup[]
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function findAllActive(): array
    {
        $request = $this->requestBuilder->find(
            AcademicGroup::getEntityName(),
            [
                'AcademicGroupArhiv' => '0'
            ]
        )
            ->buildRequest();

        $response = $this->nsiClient->send($request);

        return (new NsiModelCollection($response->getResult(), AcademicGroup::class))->asArray();
    }
}
