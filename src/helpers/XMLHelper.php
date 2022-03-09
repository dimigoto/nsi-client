<?php

declare(strict_types=1);

namespace Nsi\helpers;

use SimpleXMLElement;

use function FluidXml\fluidxml;

class XMLHelper
{
    /**
     * Вкладывает элемент $new в элемент $root
     *
     * @param SimpleXMLElement $root
     * @param SimpleXMLElement $new
     */
    public static function merge(SimpleXMLElement $root, SimpleXMLElement $new): void
    {
        $node = $root->addChild($new->getName(), (string)$new);

        foreach ($new->attributes() as $attr => $value) {
            $node->addAttribute($attr, $value);
        }

        foreach ($new->children() as $ch) {
            self::merge($node, $ch);
        }
    }


    /**
     * Преобразует массив в датаграмму
     *
     * @param array $array
     *
     * @return string
     */
    public static function arrayToDatagramString(array $array): string
    {
        $xml = fluidxml(
            null,
            [
                'root' => 'x-datagram',
            ]
        )
            ->setAttribute('xmlns', 'http://www.croc.ru/Schemas/Dvfu/Nsi/Datagram/1.0');

        $xml->add($array);

        return $xml->xml(true);
    }
}
