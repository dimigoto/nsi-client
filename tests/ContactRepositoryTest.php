<?php

declare(strict_types=1);

namespace Nsi\Tests;

use Nsi\exceptions\NsiNotFoundException;
use Nsi\exceptions\NsiResponseWithErrorException;
use Nsi\NsiClient;
use Nsi\NsiRequestBuilder;
use Nsi\repository\ContactRepository;
use Nsi\Tests\mocks\FizlitcoBaseMock;
use Nsi\Tests\mocks\FizlitcoTsoMock;
use PHPUnit\Framework\TestCase;

class ContactRepositoryTest extends TestCase
{
    private ContactRepository $contactRepository;
    private const WSDL = '';
    private const SOURCE = 'RTG';

    /**
     * @var FizlitcoBaseMock[]
     */
    private array $mockClasses;


    protected function setUp(): void
    {
        parent::setUp();

        $this->contactRepository = new ContactRepository(
            new NsiClient(static::WSDL),
            new NsiRequestBuilder(static::SOURCE)
        );

        $this->mockClasses = [
            'fizlitco.tso' => FizlitcoTsoMock::class
        ];
    }

    /**
     * Тест на поиск контактной информации по идентификатору
     *
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function testFindOneById(): void
    {
        foreach ($this->mockClasses as $mockClass) {
            $contactMock = $mockClass::createContactMock();
            $contact = $this->contactRepository->findOneById($contactMock->id);

            $this->assertEquals($contactMock, $contact);
        }
    }

    /**
     * Тест на поиск контактной информации по идентификатору физлица
     *
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function testFindAllByHumanId(): void
    {
        foreach ($this->mockClasses as $mockClass) {
            $contactMock = $mockClass::createContactMock();
            $contacts = $this->contactRepository->findAllByHumanId($contactMock->human->id);

            $this->assertEquals($contactMock, $contacts[0]);
        }
    }
}
