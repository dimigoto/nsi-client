<?php

declare(strict_types=1);

namespace Nsi\repository;

use Nsi\exceptions\NsiNotFoundException;
use Nsi\exceptions\NsiResponseWithErrorException;
use Nsi\models\Employee;
use Nsi\models\NsiModelCollection;

class EmployeeRepository extends BaseRepository
{
    /**
     * Возвращает профиль сотрудника по идентификатору
     *
     * @param string $id
     *
     * @return Employee
     *
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function findOneById(string $id): Employee
    {
        $request = $this->requestBuilder->find(
            Employee::getEntityName(),
            [
                'ID' => $id
            ]
        )
            ->buildRequest();

        $response = $this->nsiClient->send($request);

        return Employee::fromSimpleXMLElement($response->getResult()->Employee);
    }

    /**
     * Возвращает список профилей сотрудника конкретного физлица
     *
     * @param string $id
     *
     * @return Employee[]
     *
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function findAllByHumanId(string $id): array
    {
        $request = $this->requestBuilder->find(
            Employee::getEntityName(),
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

        return (new NsiModelCollection($response->getResult(), Employee::class))->asArray();
    }
}
