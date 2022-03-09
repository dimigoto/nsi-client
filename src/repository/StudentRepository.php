<?php

declare(strict_types=1);

namespace Nsi\repository;

use Nsi\exceptions\NsiNotFoundException;
use Nsi\exceptions\NsiResponseWithErrorException;
use Nsi\models\Department;
use Nsi\models\NsiModelCollection;
use Nsi\models\Student;

class StudentRepository extends BaseRepository
{
    /**
     * Возвращает профиль студента по идентификатору
     *
     * @param string $id
     *
     * @return Student
     *
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function findOneById(string $id): Student
    {
        $request = $this->requestBuilder->find(
            Student::getEntityName(),
            [
                'ID' => $id
            ]
        )
            ->buildRequest();

        $response = $this->nsiClient->send($request);

        return Student::fromSimpleXMLElement($response->getResult()->Student);
    }

    /**
     * Возвращает массив профилей студента для конкретного физлица
     *
     * @param string $id
     *
     * @return Student[]
     *
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function findAllByHumanId(string $id): array
    {
        $request = $this->requestBuilder->find(
            Student::getEntityName(),
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

        return (new NsiModelCollection($response->getResult(), Student::class))->asArray();
    }

    /**
     * Возвращает массив профилей студентов, которые выпустились в $year году
     *
     * @param int $year
     *
     * @return array
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function findAllAlumniByGraduationYear(int $year): array
    {
        $request = $this->requestBuilder->find(
            Student::getEntityName(),
            [
                'StudentYearEnd' => $year
            ]
        )
            ->buildRequest();

        $response = $this->nsiClient->send($request);

        return (new NsiModelCollection($response->getResult(), Student::class))->asArray();
    }

    /**
     * @param Department $school
     *
     * @return array
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function findAllAlumniOfSchool(Department $school): array
    {
        $request = $this->requestBuilder->find(
            Student::getEntityName(),
            [
                'StudentStatusID' => [
                    'StudentStatus' => [
                        'ID' => '07e3a807-829b-3e12-acdb-70f815b14986'
                    ]
                ],
                'EducationalProgramID' => [
                    'EducationalProgram' => [
                        'DepartmentID' => [
                            'Department' => [
                                'ID' => $school->id
                            ]
                        ]
                    ]
                ]
            ]
        )
            ->buildRequest();

        $response = $this->nsiClient->send($request);

        return (new NsiModelCollection($response->getResult(), Student::class))->asArray();
    }
}
