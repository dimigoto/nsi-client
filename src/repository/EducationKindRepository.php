<?php

declare(strict_types=1);

namespace Nsi\repository;

use Nsi\exceptions\NsiNotFoundException;
use Nsi\exceptions\NsiResponseWithErrorException;
use Nsi\models\EducationKind;
use Nsi\models\NsiModelCollection;

class EducationKindRepository extends BaseRepository
{
    /**
     * Возвращает виды образования по идентификатору
     *
     * @param string $id
     *
     * @return EducationKind
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function findOneById(string $id): EducationKind
    {
        $request = $this->requestBuilder->find(
            EducationKind::getEntityName(),
            [
                'ID' => $id
            ]
        )
            ->buildRequest();

        $response = $this->nsiClient->send($request);

        return EducationKind::fromSimpleXMLElement($response->getResult()->EducationKind);
    }

    /**
     * Возвращает все виды образования.
     *
     * @return EducationKind[]
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function findAll(): array
    {
        $request = $this->requestBuilder->find(EducationKind::getEntityName(), [])
            ->buildRequest();

        $response = $this->nsiClient->send($request);

        return (new NsiModelCollection($response->getResult(), EducationKind::class))->asArray();
    }
}
