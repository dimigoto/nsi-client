<?php

declare(strict_types=1);

namespace Nsi\repository;

use Nsi\exceptions\NsiNotFoundException;
use Nsi\exceptions\NsiResponseWithErrorException;
use Nsi\models\EducationForm;
use Nsi\models\NsiModelCollection;

class EducationFormRepository extends BaseRepository
{
    /**
     * Возвращает форму обучения по идентификатору
     *
     * @param string $id
     *
     * @return EducationForm
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function findOneById(string $id): EducationForm
    {
        $request = $this->requestBuilder->find(
            EducationForm::getEntityName(),
            [
                'ID' => $id
            ]
        )
            ->buildRequest();

        $response = $this->nsiClient->send($request);

        return EducationForm::fromSimpleXMLElement($response->getResult()->EducationForm);
    }

    /**
     * Возвращает все формы обучения.
     *
     * @return EducationForm[]
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function findAll(): array
    {
        $request = $this->requestBuilder->find(EducationForm::getEntityName(), [])
            ->buildRequest();

        $response = $this->nsiClient->send($request);

        return (new NsiModelCollection($response->getResult(), EducationForm::class))->asArray();
    }
}
