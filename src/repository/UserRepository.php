<?php

declare(strict_types=1);

namespace Nsi\repository;

use Nsi\exceptions\NsiNotFoundException;
use Nsi\exceptions\NsiResponseWithErrorException;
use Nsi\models\Contact;
use Nsi\models\Contractor;
use Nsi\models\Employee;
use Nsi\models\Human;
use Nsi\models\Student;
use Nsi\models\User;
use Nsi\NsiClient;
use Nsi\NsiRequestBuilder;

class UserRepository
{
    private NsiClient $nsiClient;
    private NsiRequestBuilder $requestBuilder;

    public function __construct(
        NsiClient $nsiClient,
        NsiRequestBuilder $requestBuilder
    ) {
        $this->nsiClient = $nsiClient;
        $this->requestBuilder = $requestBuilder;
    }

    /**
     * Возвращает все связные с пользователем сущности по идентификатору физлица
     *
     * @param string $id
     *
     * @return User
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function findOneByHumanId(string $id): User
    {
        $request = $this->requestBuilder
            ->find(
                Human::getEntityName(),
                [
                    'ID' => $id
                ]
            )
            ->andFind(
                Student::getEntityName(),
                [
                    'HumanID' => [
                        'Human' => [
                            'ID' => $id
                        ]
                    ]
                ]
            )
            ->andFind(
                Employee::getEntityName(),
                [
                    'HumanID' => [
                        'Human' => [
                            'ID' => $id
                        ]
                    ]
                ]
            )
            ->andFind(
                Contact::getEntityName(),
                [
                    'HumanID' => [
                        'Human' => [
                            'ID' => $id
                        ]
                    ]
                ]
            )
            ->andFind(
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

        return User::fromSimpleXMLElement($response->getResult());
    }
}
