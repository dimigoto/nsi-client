<?php

declare(strict_types=1);

namespace Nsi\Tests;

use Nsi\exceptions\NsiNotFoundException;
use Nsi\exceptions\NsiResponseWithErrorException;
use Nsi\models\Department;
use Nsi\NsiClient;
use Nsi\NsiRequestBuilder;
use Nsi\repository\DepartmentRepository;
use PHPUnit\Framework\TestCase;
use SoapFault;

class DepartmentRepositoryTest extends TestCase
{
    private DepartmentRepository $departmentRepository;
    private const WSDL = '';
    private const SOURCE = 'RTG';

    /**
     *
     * @throws SoapFault
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->departmentRepository = new DepartmentRepository(
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
        $result = $this->departmentRepository->findOneById('81850fb3-6396-11e8-acf8-00155d203d40');

        $this->assertEquals(
            'Отдел академического маркетинга и медицинской аккредитации (Архив)',
            $result->name
        );
    }

    /**
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function testFindAllSchools(): void
    {
        $result = $this->departmentRepository->findAllSchools();

        $this->assertInstanceOf(Department::class, $result[0]);
    }
}
