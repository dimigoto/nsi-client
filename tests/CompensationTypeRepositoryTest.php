<?php

declare(strict_types=1);

namespace Nsi\Tests;

use Nsi\exceptions\NsiNotFoundException;
use Nsi\exceptions\NsiResponseWithErrorException;
use Nsi\models\CompensationType;
use Nsi\NsiClient;
use Nsi\NsiRequestBuilder;
use Nsi\repository\AcademicGroupRepository;
use Nsi\repository\CompensationTypeRepository;
use PHPUnit\Framework\TestCase;
use SoapFault;

class CompensationTypeRepositoryTest extends TestCase
{
    private CompensationTypeRepository $compensationTypeRepository;
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

        $this->compensationTypeRepository = new CompensationTypeRepository(
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
        $result = $this->compensationTypeRepository->findOneById('57fa54b7-f786-3c19-8594-2d4e5838939a');

        $this->assertEquals(
            'Бюджетная основа',
            $result->name
        );
    }

    /**
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function testFindAll(): void
    {
        $result = $this->compensationTypeRepository->findAll();

        $this->assertInstanceOf(CompensationType::class, $result[0]);
    }
}
