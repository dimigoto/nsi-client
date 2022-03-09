<?php

declare(strict_types=1);

namespace Nsi\Tests;

use Nsi\exceptions\NsiNotFoundException;
use Nsi\exceptions\NsiResponseWithErrorException;
use Nsi\models\CompensationType;
use Nsi\models\ContactKind;
use Nsi\NsiClient;
use Nsi\NsiRequestBuilder;
use Nsi\repository\AcademicGroupRepository;
use Nsi\repository\CompensationTypeRepository;
use Nsi\repository\ContactKindRepository;
use PHPUnit\Framework\TestCase;
use SoapFault;

class ContactKindRepositoryTest extends TestCase
{
    private ContactKindRepository $contactKindRepository;
    private const WSDL = '';
    private const SOURCE = 'RTG';

    /**
     * Настройка тестов
     *
     * @throws SoapFault
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->contactKindRepository = new ContactKindRepository(
            new NsiClient(static::WSDL,
                [
                    'connection_timeout' => 1000
                ]
            ),
            new NsiRequestBuilder(static::SOURCE)
        );

        ini_set('default_socket_timeout', '1000');
    }

    /**
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function testFindOneById(): void
    {
        $result = $this->contactKindRepository->findOneById('e2ced546-5180-11e8-acf8-00155d203d40');

        $this->assertEquals(
            'Электронная почта',
            $result->name
        );
    }

    /**
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function testFindAll(): void
    {
        $result = $this->contactKindRepository->findAll();

        $this->assertInstanceOf(ContactKind::class, $result[0]);
    }
}
