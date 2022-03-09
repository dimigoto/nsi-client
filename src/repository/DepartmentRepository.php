<?php

declare(strict_types=1);

namespace Nsi\repository;

use Nsi\exceptions\NsiNotFoundException;
use Nsi\exceptions\NsiResponseWithErrorException;
use Nsi\models\Department;
use Nsi\models\NsiModelCollection;

class DepartmentRepository extends BaseRepository
{
    private const DEPARTMENT_SCHOOL_GUID = '144d413c-9af7-482b-9d39-8f1d2b666ad7';

    /**
     * Возвращает подразделение по идентификатору
     *
     * @param string $id
     *
     * @return Department
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function findOneById(string $id): Department
    {
        $request = $this->requestBuilder->find(
            Department::getEntityName(),
            [
                'ID' => $id
            ]
        )
            ->buildRequest();

        $response = $this->nsiClient->send($request);

        return Department::fromSimpleXMLElement($response->getResult()->Department);
    }

    /**
     * Возвращает все подразделения. Внимание! Запрос очень долгий, рекомендуется увеличить таймаут сокетов
     * и SoapClient
     *
     * @return Department[]
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function findAll(): array
    {
        $request = $this->requestBuilder->find(Department::getEntityName(), [])
            ->buildRequest();

        $response = $this->nsiClient->send($request);

        return (new NsiModelCollection($response->getResult(), Department::class))->asArray();
    }

    /**
     * Возвращает все не архивные подразделения. Внимание! Запрос очень долгий, рекомендуется увеличить таймаут сокетов
     * и SoapClient
     *
     * @return Department[]
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function findAllActive(): array
    {
        $request = $this->requestBuilder->find(
            Department::getEntityName(),
            [
                'IsArchive' => '0'
            ]
        )
            ->buildRequest();

        $response = $this->nsiClient->send($request);

        return (new NsiModelCollection($response->getResult(), Department::class))->asArray();
    }

    /**
     * Возвращает список всех школ
     *
     * @return array
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function findAllSchools(): array
    {
        $request = $this->requestBuilder->find(
            Department::getEntityName(),
            [
                'DepartmentUpper' => [
                    'Department' => [
                        'ID' => static::DEPARTMENT_SCHOOL_GUID
                    ]
                ]
            ]
        )
            ->buildRequest();

        $response = $this->nsiClient->send($request);

        return (new NsiModelCollection($response->getResult(), Department::class))->asArray();
    }
}
