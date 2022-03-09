<?php

declare(strict_types=1);

namespace Nsi;

use Nsi\models\NsiModel;
use Ramsey\Uuid\Uuid;

class NsiRequestBuilder
{
    private const OPERATION_TYPE_RETRIEVE = 'retrieve';
    private const OPERATION_TYPE_UPDATE = 'update';

    private string $source;
    private string $operationType;
    private NsiDatagram $datagram;

    /**
     * @param string $source
     */
    public function __construct(string $source)
    {
        $this->source = $source;
    }

    /**
     * Возвращает датаграмму
     *
     * @return NsiDatagram
     */
    public function getDatagram(): NsiDatagram
    {
        return $this->datagram;
    }

    /**
     * Присваивает датаграмму
     *
     * @param NsiDatagram $datagram
     *
     * @return NsiRequestBuilder
     */
    public function setDatagram(NsiDatagram $datagram): self
    {
        $this->datagram = $datagram;

        return $this;
    }

    /**
     * Создает запрос на поиск сущности
     *
     * @param string $entity
     * @param array $conditions
     *
     * @return $this
     */
    public function find(string $entity, array $conditions = []): self
    {
        $this->operationType = static::OPERATION_TYPE_RETRIEVE;

        $this->datagram = new NsiDatagram();
        $this->datagram->addEntity($entity);
        $this->datagram->addConditionsForEntity($entity, $conditions);

        return $this;
    }

    /**
     * Добавляет поиск по ещё одной сущности к запросу
     *
     * @param string $entity
     * @param array $conditions
     *
     * @return $this
     */
    public function andFind(string $entity, array $conditions = []): self
    {
        $this->datagram->addEntity($entity);
        $this->datagram->addConditionsForEntity($entity, $conditions);

        return $this;
    }

    /**
     * Создает запрос на обновление сущности
     *
     * @param string $entity
     * @param array $setOfValues
     * @param array $conditions
     *
     * @return $this
     */
    public function update(string $entity, array $setOfValues, array $conditions): self
    {
        $this->operationType = static::OPERATION_TYPE_UPDATE;

        $this->datagram = new NsiDatagram();
        $this->datagram->addEntity($entity);
        $this->datagram->addConditionsForEntity($entity, $conditions);
        $this->datagram->addValuesToUpdateForEntity($entity, $setOfValues);

        return $this;
    }

    /**
     * Обертка над update, генерирует запрос на обновление модели
     *
     * @param NsiModel $model
     * @param int|null $level
     *
     * @return $this
     */
    public function updateModel(NsiModel $model, ?int $level = 0): self
    {
        $entity = $model::getEntityName();
        $modelDatagram = $model->toNsiDatagram()[$entity];

        if ($level !== null) {
            $modelDatagram = $this->replaceModelsWithReference($modelDatagram, $level);
        }

        return $this->update($entity, $modelDatagram, ['ID' => $modelDatagram['ID']]);
    }

    /**
     * Возвращает датаграмму в виде массива
     *
     * @return array
     */
    public function buildDatagramAsArray(): array
    {
        $result = [];

        foreach ($this->datagram->getEntities() as $entity) {
            $result[] = [
                $entity => $this->mergeConditionsAndValues($entity)
            ];
        }

        return $result;
    }

    /**
     * Возвращает объект запроса
     *
     * @param string|null $requestId
     *
     * @return NsiRequest
     */
    public function buildRequest(?string $requestId = null): NsiRequest
    {
        $request = new NsiRequest();

        $request->setRoutingHeader(
            $this->operationType,
            $this->source,
            $requestId ?? Uuid::uuid4()->toString()
        );

        $request->setDatagramFromArray($this->buildDatagramAsArray());

        return $request;
    }

    /**
     * Склеивает данные условий запроса и данных, которые нужно обновить в единый массив.
     *
     * @param string $entity
     *
     * @return array
     */
    private function mergeConditionsAndValues(string $entity): array
    {
        return array_merge(
            $this->datagram->getConditionsForEntity($entity),
            $this->datagram->getValuesToUpdateForEntity($entity)
        );
    }

    /**
     * Заменяет модели на ссылки
     *
     * @param array $modelDatagram
     * @param int $level
     * @param int $currentLevel
     *
     * @return array
     */
    private function replaceModelsWithReference(array $modelDatagram, int $level, int $currentLevel = 0): array
    {
        $result = $modelDatagram;

        foreach ($modelDatagram as $key => $value) {
            if (!is_array($value)) {
                $result[$key] = $value;

                continue;
            }

            foreach ($value as $innerKey => $childValue) {
                if ($currentLevel === $level) {
                    $result[$key][$innerKey] = [
                        'ID' => $childValue['ID']
                    ];

                    continue;
                }

                $result[$key][$innerKey] = static::replaceModelsWithReference(
                    $childValue,
                    $level,
                    $currentLevel + 1
                );
            }
        }

        return $result;
    }
}
