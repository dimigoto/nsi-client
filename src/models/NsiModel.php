<?php

declare(strict_types=1);

namespace Nsi\models;

use Nsi\interfaces\NsiModelDTOInterface;
use SimpleXMLElement;

abstract class NsiModel implements NsiModelDTOInterface
{
    private string $analogs;
    private bool $isNotConsistent;

    /**
     * Возвращает название сущности в НСИ
     *
     * @return string
     */
    abstract public static function getEntityName(): string;

    /**
     * Конвертирует XML в объект NsiModel
     *
     * @param SimpleXMLElement $element
     *
     * @return static
     */
    public static function fromSimpleXMLElement(SimpleXMLElement $element): self
    {
        $result = new static();

        $result->analogs = isset($element->attributes()['analogs']) ? (string)$element->attributes()['analogs'] : '';
        $result->isNotConsistent = isset($element->attributes()['isNotConsistent']) &&
            (int)$element->attributes()['isNotConsistent'] === 1;

        return $result;
    }

    /**
     * Возвращает набор идентификаторов сущности, которые используются другими системами
     *
     * @return string
     */
    public function getAnalogs(): string
    {
        return $this->analogs;
    }

    /**
     * Устанавливает набор идентификаторов сущности, которые используются другими системами
     *
     * @param string $analogs
     */
    public function setAnalogs(string $analogs): void
    {
        $this->analogs = $analogs;
    }

    /**
     * Возвращает истину, если у сущности есть проблемы связанные с объединением дублей
     *
     * @return bool
     */
    public function isNotConsistent(): bool
    {
        return $this->isNotConsistent;
    }

    /**
     * Сеттер консистентности сущности
     *
     * @param bool $isConsistent
     */
    public function setConsistent(bool $isConsistent = true): void
    {
        $this->isNotConsistent = !$isConsistent;
    }

    /**
     * Возвращает истину, если у сущности есть идентификаторы других систем
     *
     * @return bool
     */
    public function hasAnalogs(): bool
    {
        return !empty($this->getAnalogs());
    }

    /**
     * Возвращает массив идентификаторов, сгруппированных по системе
     *
     * @return array
     */
    public function getAnalogsBySources(): array
    {
        $result = [];
        $sourcesAnalogs = explode(';', $this->getAnalogs());

        foreach ($sourcesAnalogs as $analogs) {
            [$source, $id] = explode('=', $analogs);
            $result[$source] = $id;
        }

        return $result;
    }

    /**
     * Возвращает массив уникальных идентификаторов
     *
     * @return array
     */
    public function getUniqAnalogs(): array
    {
        return array_unique(array_values($this->getAnalogsBySources()));
    }

    /**
     * Возвращает истину, если сущность является просто ссылкой на сущность в НСИ. НСИ возвращает вложенные сущности,
     * но есть максимальный уровень вложенности, дойдя до которого НСИ возвращает только идентификатор сущности. Таким
     * образом все остальные свойства сущности оказываются пустыми. Такие сущности можно назвать ссылочными и их
     * нужно "дозапрашивать" если есть необходимость в их использовании.
     *
     * @return bool
     */
    public function isReference(): bool
    {
        $properties = get_class_vars(static::class);

        if ((count($properties) === 1) && !empty($this->$properties[0])) {
            return false;
        }

        return $this->filledPropertiesCount() === 1;
    }

    /**
     * Возвращает количество не пустых свойств объекта
     *
     * @return int
     */
    private function filledPropertiesCount(): int
    {
        $filledPropertiesCount = 0;

        foreach (get_class_vars(static::class) as $property) {
            if (!empty($this->$property)) {
                $filledPropertiesCount++;
            }
        }

        return $filledPropertiesCount;
    }
}
