<?php

declare(strict_types=1);

namespace Nsi;

use Nsi\helpers\XMLHelper;
use SoapVar;

class NsiRequest
{
    /**
     * Датаграмма
     */
    private SoapVar $datagram;
    private string $operationType;
    private string $sourceId;
    private string $messageId;

    /**
     * Присваивает датаграмму в виде объекта SoapVar
     *
     * @param SoapVar $datagram
     */
    public function setDatagram(SoapVar $datagram): void
    {
        $this->datagram = $datagram;
    }

    /**
     * Возвращает датаграмму
     *
     * @return SoapVar
     */
    public function getDatagram(): SoapVar
    {
        return $this->datagram;
    }

    /**
     * Присваивает датаграмму. В качестве аргумента необходимо передать XML-структуру. Метод конвертирует строку в
     * экземпляр объекта SoapVar
     *
     * @param string $datagram
     */
    public function setDatagramFromString(string $datagram): void
    {
        $this->setDatagram(
            new SoapVar($datagram, XSD_ANYXML)
        );
    }

    /**
     * Присваивает датаграмму. В качестве аргумента необходимо передать массив. Метод конвертирует массив в
     * экземпляр объекта SoapVar
     *
     * @param array $datagram
     */
    public function setDatagramFromArray(array $datagram): void
    {
        $this->setDatagramFromString(
            XMLHelper::arrayToDatagramString($datagram)
        );
    }

    /**
     * Присваивает тип операции. Тип операции может быть retrieve, insert, update или delete.
     *
     * @param string $method
     */
    public function setOperationType(string $method): void
    {
        $this->operationType = $method;
    }

    /**
     * Возвращает тип операции
     *
     * @return string
     */
    public function getOperationType(): string
    {
        return $this->operationType;
    }

    /**
     * Присваивает идентификатор источника
     *
     * @param string $sourceId
     */
    public function setSourceId(string $sourceId): void
    {
        $this->sourceId = $sourceId;
    }

    /**
     * Возвращает идентификатор источника
     *
     * @return string
     */
    public function getSourceId(): string
    {
        return $this->sourceId;
    }

    /**
     * Присваивает идентификатор сообщения
     *
     * @param string $messageId
     */
    public function setMessageId(string $messageId): void
    {
        $this->messageId = $messageId;
    }

    /**
     * Возвращает идентификатор сообщения
     *
     * @return string
     */
    public function getMessageId(): string
    {
        return $this->messageId;
    }

    /**
     * Устанавливает заголовок запроса
     *
     * @param string $operationType
     * @param string $sourceId
     * @param string $messageId
     */
    public function setRoutingHeader(string $operationType, string $sourceId, string $messageId): void
    {
        $this->setOperationType($operationType);
        $this->setSourceId($sourceId);
        $this->setMessageId($messageId);
    }

    /**
     * Возвращает заголовок запроса, предварительно сгенерировав его
     *
     * @return array
     */
    public function getRoutingHeader(): array
    {
        return $this->generateRoutingHeader();
    }

    /**
     * Возвращает запрос в виде массива
     *
     * @return array
     */
    public function getRequest(): array
    {
        return $this->generateRequest();
    }

    /**
     * Генерирует массив заголовка запроса
     *
     * @return array
     */
    private function generateRoutingHeader(): array
    {
        return [
            'operationType' => $this->getOperationType(),
            'sourceId' => $this->getSourceId(),
            'messageId' => $this->getMessageId()
        ];
    }

    /**
     * Генерирует запрос в виде массива
     */
    private function generateRequest(): array
    {
        return [
            'routingHeader' => $this->getRoutingHeader(),
            'datagram' => [
                'any' => $this->datagram
            ]
        ];
    }
}
