<?php

declare(strict_types=1);

namespace Nsi\repository;

use Nsi\exceptions\NsiNotFoundException;
use Nsi\exceptions\NsiRecordExistsException;
use Nsi\exceptions\NsiResponseWithErrorException;
use Nsi\models\NsiModel;
use Nsi\NsiClient;
use Nsi\NsiRequestBuilder;

abstract class BaseRepository
{
    protected NsiClient $nsiClient;
    protected NsiRequestBuilder $requestBuilder;

    public function __construct(
        NsiClient $nsiClient,
        NsiRequestBuilder $requestBuilder
    ) {
        $this->nsiClient = $nsiClient;
        $this->requestBuilder = $requestBuilder;
    }

    /**
     * Сохраняет модель в НСИ.
     * Внимание! Данные метод работает как на обновление, так и на запись новой модели. Если модель нужно только
     * обновить, то лучше воспользоваться методом update, в методе update есть проверка на существование модели. Если
     * нужно создать новую запись, то лучше воспользоваться методом insert. В методе insert есть проверка на то, что
     * модели не существует.
     *
     * @param NsiModel $model
     *
     * @throws NsiResponseWithErrorException
     */
    public function save(NsiModel $model): void
    {
        $request = $this->requestBuilder
            ->updateModel($model)
            ->buildRequest();
        try {
            $this->nsiClient->send($request);
        } catch (NsiNotFoundException $e) {
            // Данного исключения быть не может
        }
    }

    /**
     * Если нужно обновить запись в НСИ, то лучше воспользоваться данным методом, так как в нём происходит проверка на
     * существование записи
     *
     * @param NsiModel $model
     *
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function update(NsiModel $model): void
    {
        /** @var NsiModel $modelClass */
        $modelClass = get_class($model);

        $request = $this->requestBuilder
            ->find(
                $modelClass::getEntityName(),
                [
                    'ID' => $model->id
                ]
            )
            ->buildRequest();

        $this->nsiClient->send($request);

        // Если модель найдена, то сохраняем обновление
        $this->save($model);
    }

    /**
     * Если нужно вставить новую запись, то лучше воспользоваться этим методом, так как в нем происходит проверка на
     * то, что запись не существует.
     *
     * @param NsiModel $model
     *
     * @throws NsiRecordExistsException
     * @throws NsiResponseWithErrorException
     */
    public function insert(NsiModel $model): void
    {
        /** @var NsiModel $modelClass */
        $modelClass = get_class($model);

        $request = $this->requestBuilder
            ->find(
                $modelClass::getEntityName(),
                [
                    'ID' => $model->id
                ]
            )
            ->buildRequest();

        try {
            $this->nsiClient->send($request);
        } catch (NsiNotFoundException $e) {
            // Если модель не найдена, то вставляем запись
            $this->save($model);
        }

        throw new NsiRecordExistsException('Запись уже существует');
    }
}
