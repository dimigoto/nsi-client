<?php

declare(strict_types=1);

namespace Nsi\Tests;

use Nsi\exceptions\NsiNotFoundException;
use Nsi\exceptions\NsiResponseWithErrorException;
use Nsi\NsiClient;
use Nsi\NsiRequestBuilder;
use Nsi\repository\EmployeeRepository;
use Nsi\Tests\mocks\FizlitcoBaseMock;
use Nsi\Tests\mocks\FizlitcoTsoMock;
use PHPUnit\Framework\TestCase;

class EmployeeRepositoryTest extends TestCase
{
    private EmployeeRepository $employeeRepository;
    private const WSDL = '';
    private const SOURCE = 'RTG';

    /**
     * @var FizlitcoBaseMock[]
     */
    private array $mockClasses;


    protected function setUp(): void
    {
        parent::setUp();

        $this->employeeRepository = new EmployeeRepository(
            new NsiClient(static::WSDL),
            new NsiRequestBuilder(static::SOURCE)
        );

        $this->mockClasses = [
            'fizlitco.tso' => FizlitcoTsoMock::class
        ];
    }

    /**
     * Тест на поиск сотрудника по идентификатору
     *
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function testFindOneById(): void
    {
        foreach ($this->mockClasses as $mockClass) {
            $employeeMock = $mockClass::createEmployeeMock();
            $employee = $this->employeeRepository->findOneById($employeeMock->id);

            $this->assertEquals($employeeMock, $employee);
        }
    }

    /**
     * Тест на поиск сотрудника информации по идентификатору физлица
     *
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function testFindAllByHumanId(): void
    {
        foreach ($this->mockClasses as $mockClass) {
            $employeeMock = $mockClass::createEmployeeMock();
            $employee = $this->employeeRepository->findAllByHumanId($employeeMock->human->id);

            $this->assertEquals($employeeMock, $employee[0]);
        }
    }
}
