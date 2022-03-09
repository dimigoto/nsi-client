<?php

declare(strict_types=1);

namespace Nsi;

use Nsi\exceptions\NsiNotFoundException;
use Nsi\exceptions\NsiResponseWithErrorException;
use SimpleXMLElement;

class NsiResponse
{
    private const ERROR_NO_DATA_FOUND = 'No data found';

    private object $response;
    private SimpleXMLElement $result;

    /**
     * @throws NsiResponseWithErrorException|NsiNotFoundException
     */
    public function __construct(object $response)
    {
        $this->response = $response;

        if ($response->callCC === 0 || $response->callCC === 1) {
            $result = simplexml_load_string($this->response->datagram->any);

            if ($result instanceof SimpleXMLElement) {
                $this->result = $result;
            }

            return;
        }

        if ($response->callRC === static::ERROR_NO_DATA_FOUND) {
            throw new NsiNotFoundException($response->callRC);
        }

        throw new NsiResponseWithErrorException($response->callRC);
    }

    /**
     * Возвращает результат запроса в виде объекта SimpleXMLElement
     *
     * @return SimpleXMLElement|null
     */
    public function getResult(): ?SimpleXMLElement
    {
        return $this->result;
    }

    /**
     * Возвращает сырой ответ
     *
     * @return object
     */
    public function getRawResponse(): object
    {
        return $this->response;
    }
}
