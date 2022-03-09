<?php

declare(strict_types=1);

namespace Nsi\models;

use SimpleXMLElement;

class NsiModelCollection
{
    private SimpleXMLElement $element;
    private string $modelClassName;
    private array $collection;

    public function __construct(SimpleXMLElement $element, string $modelClassName)
    {
        $this->element = $element;
        $this->modelClassName = $modelClassName;

        $this->fillCollection();
    }

    /**
     * Возвращает коллекцию моделей в виде массива
     *
     * @return array
     */
    public function asArray(): array
    {
        return $this->collection;
    }

    /**
     * Заполняет массив коллекции данными
     */
    private function fillCollection(): void
    {
        foreach ($this->element as $model) {
            $this->collection[] = call_user_func(
                [
                    $this->modelClassName,
                    'fromSimpleXMLElement'
                ],
                $model
            );
        }
    }
}
