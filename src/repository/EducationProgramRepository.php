<?php

declare(strict_types=1);

namespace Nsi\repository;

use Nsi\exceptions\NsiNotFoundException;
use Nsi\exceptions\NsiResponseWithErrorException;
use Nsi\models\EducationProgram;
use Nsi\models\NsiModelCollection;

class EducationProgramRepository extends BaseRepository
{
    /**
     * Возвращает образовательную программу по идентификатору
     *
     * @param string $id
     *
     * @return EducationProgram
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function findOneById(string $id): EducationProgram
    {
        $request = $this->requestBuilder->find(
            EducationProgram::getEntityName(),
            [
                'ID' => $id
            ]
        )
            ->buildRequest();

        $response = $this->nsiClient->send($request);

        return EducationProgram::fromSimpleXMLElement($response->getResult()->EducationalProgram);
    }

    /**
     * Возвращает все образовательные программы.
     *
     * @return EducationProgram[]
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function findAll(): array
    {
        $request = $this->requestBuilder->find(EducationProgram::getEntityName(), [])
            ->buildRequest();

        $response = $this->nsiClient->send($request);

        return (new NsiModelCollection($response->getResult(), EducationProgram::class))->asArray();
    }
}
