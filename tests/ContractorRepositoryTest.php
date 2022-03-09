<?php

declare(strict_types=1);

namespace Nsi\Tests;

use Nsi\exceptions\NsiNotFoundException;
use Nsi\exceptions\NsiResponseWithErrorException;
use Nsi\NsiClient;
use Nsi\NsiRequestBuilder;
use Nsi\repository\ContractorRepository;
use Nsi\Tests\mocks\FizlitcoBaseMock;
use Nsi\Tests\mocks\FizlitcoTsoMock;
use PHPUnit\Framework\TestCase;

class ContractorRepositoryTest extends TestCase
{
    private ContractorRepository $contractorRepository;
    private const WSDL = '';
    private const SOURCE = 'RTG';

    /**
     * @var FizlitcoBaseMock[]
     */
    private array $mockClasses;


    protected function setUp(): void
    {
        parent::setUp();

        $this->contractorRepository = new ContractorRepository(
            new NsiClient(static::WSDL),
            new NsiRequestBuilder(static::SOURCE)
        );

        $this->mockClasses = [
            'fizlitco.tso' => FizlitcoTsoMock::class
        ];
    }

    /**
     * Тест на поиск контрагента по идентификатору
     *
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function testFindOneById(): void
    {
        foreach ($this->mockClasses as $mockClass) {
            $contractorMock = $mockClass::createContractorMock();
            $contractor = $this->contractorRepository->findOneById($contractorMock->id);

            $this->assertEquals($contractorMock, $contractor);
        }
    }

    /**
     * Тест на поиск контрагента по идентификатору физлица
     *
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function testFindAllByHumanId(): void
    {
        foreach ($this->mockClasses as $mockClass) {
            $contractorMock = $mockClass::createContractorMock();
            $contractors = $this->contractorRepository->findAllByHumanId($contractorMock->human->id);

            $this->assertEquals($contractorMock, $contractors[0]);
        }
    }
}
