<?php

declare(strict_types=1);

namespace Nsi\interfaces;

use SimpleXMLElement;

interface NsiModelDTOInterface
{
    /**
     * Заполняет атрибуты объекта данными из ответа НСИ
     *
     * @param SimpleXMLElement $element
     *
     * @return static
     */
    public static function fromSimpleXMLElement(SimpleXMLElement $element): self;

    /**
     * Возвращает массив с моделью, которую можно конвертировать в датаграмму запроса в НСИ
     *
     * @return array
     */
    public function toNsiDatagram(): array;
}
