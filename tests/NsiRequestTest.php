<?php

declare(strict_types=1);

namespace Nsi\Tests;

use Nsi\NsiRequest;
use PHPUnit\Framework\TestCase;

class NsiRequestTest extends TestCase
{
    private const DATAGRAM_RESULT_VALUE =
        "<x-datagram xmlns=\"http://www.croc.ru/Schemas/Dvfu/Nsi/Datagram/1.0\">\n  <ID>1</ID>\n</x-datagram>";

    /**
     * Тест на добавление датаграммы в виде строки
     */
    public function testSetDatagramFromString(): void
    {
        $request = new NsiRequest();
        $request->setDatagramFromString(static::DATAGRAM_RESULT_VALUE);

        $this->assertEquals(static::DATAGRAM_RESULT_VALUE, $request->getDatagram()->enc_value);
    }

    /**
     * Тест на добавление датаграммы в виде массива
     */
    public function testSetDatagramFromArray(): void
    {
        $request = new NsiRequest();
        $request->setDatagramFromArray(['ID' => '1']);

        $this->assertEquals(static::DATAGRAM_RESULT_VALUE, $request->getDatagram()->enc_value);
    }

    /**
     * Тест на формирование заголовка запроса
     */
    public function testSetRoutingHeader(): void
    {
        $request = new NsiRequest();
        $request->setRoutingHeader('retrieve', 'RTG', '123');

        $this->assertEquals(
            [
                'operationType' => 'retrieve',
                'sourceId' => 'RTG',
                'messageId' => '123',
            ],
            $request->getRoutingHeader()
        );
    }

    /**
     * Тест на сборку массива запроса в НСИ
     */
    public function testGetRequest(): void
    {
        $request = new NsiRequest();
        $request->setRoutingHeader('retrieve', 'RTG', '123');
        $request->setDatagramFromArray(['ID' => '1']);
        $result = $request->getRequest();

        $this->assertEquals(
            [
                'operationType' => 'retrieve',
                'sourceId' => 'RTG',
                'messageId' => '123',
            ],
            $result['routingHeader']
        );

        $this->assertEquals(
            static::DATAGRAM_RESULT_VALUE,
            $result['datagram']['any']->enc_value
        );
    }
}
