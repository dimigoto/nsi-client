<?php

declare(strict_types=1);

namespace Nsi\repository;

use Nsi\exceptions\NsiNotFoundException;
use Nsi\exceptions\NsiResponseWithErrorException;
use Nsi\models\Course;
use Nsi\models\NsiModelCollection;

class CourseRepository extends BaseRepository
{
    /**
     * Возвращает курс по идентификатору
     *
     * @param string $id
     *
     * @return Course
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function findOneById(string $id): Course
    {
        $request = $this->requestBuilder->find(
            Course::getEntityName(),
            [
                'ID' => $id
            ]
        )
            ->buildRequest();

        $response = $this->nsiClient->send($request);

        return Course::fromSimpleXMLElement($response->getResult()->Course);
    }

    /**
     * Возвращает все курсы.
     *
     * @return Course[]
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function findAll(): array
    {
        $request = $this->requestBuilder->find(Course::getEntityName(), [])
            ->buildRequest();

        $response = $this->nsiClient->send($request);

        return (new NsiModelCollection($response->getResult(), Course::class))->asArray();
    }
}
