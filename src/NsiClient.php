<?php

declare(strict_types=1);

namespace Nsi;

use Nsi\exceptions\NsiNotFoundException;
use Nsi\exceptions\NsiResponseWithErrorException;
use SoapClient;
use SoapFault;

class NsiClient
{
    private SoapClient $client;

    /**
     * @param string $wsdl
     * @param array $clientOptions
     *
     * @throws SoapFault
     */
    public function __construct(string $wsdl, array $clientOptions = [])
    {
        $this->client = new SoapClient($wsdl, $clientOptions);
    }

    /**
     * Отправляет запрос в НСИ и возвращает объект ответа NsiResponse
     *
     * @param NsiRequest $request
     *
     * @return NsiResponse
     *
     * @throws NsiResponseWithErrorException|NsiNotFoundException
     */
    public function send(NsiRequest $request): NsiResponse
    {
        $method = $request->getOperationType();
        $response = $this->client->$method($request->getRequest());

        return new NsiResponse($response);
    }
}
