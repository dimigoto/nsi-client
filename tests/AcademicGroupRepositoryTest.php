<?php

declare(strict_types=1);

namespace Nsi\Tests;

use Nsi\exceptions\NsiNotFoundException;
use Nsi\exceptions\NsiResponseWithErrorException;
use Nsi\NsiClient;
use Nsi\NsiRequestBuilder;
use Nsi\repository\AcademicGroupRepository;
use PHPUnit\Framework\TestCase;
use SoapFault;

class AcademicGroupRepositoryTest extends TestCase
{
    private AcademicGroupRepository $academicGroupRepository;
    private const WSDL = '';
    private const SOURCE = 'RTG';

    /**
     *
     * @throws SoapFault
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->academicGroupRepository = new AcademicGroupRepository(
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
        $result = $this->academicGroupRepository->findOneById('89ba96ab-7a74-11e8-a1fb-00155d202c3c');

        $this->assertEquals(
            'Б5106',
            $result->name
        );
    }
}
