<?php

declare(strict_types=1);

namespace Nsi;

class NsiDatagram
{
    private array $entities = [];
    private array $conditions = [];
    private array $valuesToUpdate = [];

    /**
     * Добавляет сущность НСИ
     *
     * @param string $entity
     */
    public function addEntity(string $entity): void
    {
        $this->entities[] = $entity;
    }

    /**
     * Возвращает массив сущностей НСИ
     *
     * @return array
     */
    public function getEntities(): array
    {
        return $this->entities;
    }

    /**
     * Добавляет условия выборки для сущности НСИ
     *
     * @param string $entity
     * @param array $conditions
     *
     * @return $this
     */
    public function addConditionsForEntity(string $entity, array $conditions): self
    {
        $this->conditions[$entity] = $conditions;

        return $this;
    }

    /**
     * Возвращает массив со всеми условиями выборки
     *
     * @return array
     */
    public function getConditions(): array
    {
        return $this->conditions;
    }

    /**
     * Возвращает условия выборки конкретной сущности
     *
     * @param string $entity
     *
     * @return array
     */
    public function getConditionsForEntity(string $entity): array
    {
        return $this->conditions[$entity] ?? [];
    }

    /**
     * Добавляет массив со значениями для полей, которые нужно обновить
     *
     * @param string $entity
     * @param array $setOfValues
     */
    public function addValuesToUpdateForEntity(string $entity, array $setOfValues): void
    {
        $this->valuesToUpdate[$entity] = $setOfValues;
    }

    /**
     * Возвращает массив со значениями для полей, которые нужно обновить
     *
     * @param string $entity
     *
     * @return array
     */
    public function getValuesToUpdateForEntity(string $entity): array
    {
        return $this->valuesToUpdate[$entity] ?? [];
    }
}
