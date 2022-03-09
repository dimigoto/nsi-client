<?php

declare(strict_types=1);

namespace Nsi\Tests;

use Nsi\exceptions\NsiNotFoundException;
use Nsi\exceptions\NsiResponseWithErrorException;
use Nsi\models\Human;
use Nsi\NsiClient;
use Nsi\NsiRequestBuilder;
use PHPUnit\Framework\TestCase;

class NsiClientTest extends TestCase
{
    private const WSDL = '';
    private const SOURCE = 'RTG';

    private const CORRECT_HUMAN_GUID = '00000000-0000-0000-9999-000000000000';
    private const INCORRECT_HUMAN_GUID = '00000000-0000-0000-9999-000000000001';
    private const HUMAN_LAST_NAME = 'Физлицо';

    /**
     * Тест на отправку запроса в НСИ
     *
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function testSend(): void
    {
        $requestBuilder = new NsiRequestBuilder(static::SOURCE);
        $request = $requestBuilder->find(
            Human::getEntityName(),
            [
                'ID' => static::CORRECT_HUMAN_GUID
            ]
        )
            ->buildRequest();

        $nsiClient = new NsiClient(static::WSDL);
        $result = $nsiClient->send($request);
        $model = Human::fromSimpleXMLElement($result->getResult()->Human);

        $this->assertEquals(static::HUMAN_LAST_NAME, $model->lastName);
    }

    /**
     * Тест на ошибку "Не найдено"
     *
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function testSendNotFound(): void
    {
        $this->expectException(NsiNotFoundException::class);

        $requestBuilder = new NsiRequestBuilder(static::SOURCE);
        $request = $requestBuilder->find(
            Human::getEntityName(),
            [
                'ID' => static::INCORRECT_HUMAN_GUID
            ]
        )
            ->buildRequest();

        $nsiClient = new NsiClient(static::WSDL);
        $nsiClient->send($request);
    }
}
