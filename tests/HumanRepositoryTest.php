<?php

declare(strict_types=1);

namespace Nsi\Tests;

use Nsi\exceptions\NsiNotFoundException;
use Nsi\exceptions\NsiResponseWithErrorException;
use Nsi\NsiClient;
use Nsi\NsiRequestBuilder;
use Nsi\repository\HumanRepository;
use Nsi\Tests\mocks\FizlitcoBaseMock;
use Nsi\Tests\mocks\FizlitcoTsMock;
use Nsi\Tests\mocks\FizlitcoTsoMock;
use PHPUnit\Framework\TestCase;

class HumanRepositoryTest extends TestCase
{
    private HumanRepository $humanRepository;
    private const WSDL = '';
    private const SOURCE = 'RTG';

    /**
     * @var FizlitcoBaseMock[]
     */
    private array $mockClasses;

    protected function setUp(): void
    {
        parent::setUp();

        $this->humanRepository = new HumanRepository(
            new NsiClient(static::WSDL),
            new NsiRequestBuilder(static::SOURCE)
        );

        $this->mockClasses = [
            'fizlitco.ts' => FizlitcoTsMock::class,
            'fizlitco.tso' => FizlitcoTsoMock::class
        ];
    }

    /**
     * Тест на поиск физлица по идентификатору
     *
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function testFindOneById(): void
    {
        foreach ($this->mockClasses as $mockClass) {
            $humanMock = $mockClass::createHumanMock();
            $human = $this->humanRepository->findOneById($humanMock->id);

            $this->assertEquals($humanMock, $human);
        }
    }

    /**
     * Тест на поиск физлица по ФИО и данным паспорта
     *
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function testFindOneByFullNameAndIdentityCard(): void
    {
        foreach ($this->mockClasses as $mockClass) {
            $identityCardMock = $mockClass::createIdentityCardMock();
            $humanMock = $mockClass::createHumanMock();

            $human = $this->humanRepository->findOneByFullNameAndIdentityCard(
                $humanMock->lastName,
                $humanMock->firstName,
                $humanMock->middleName,
                $identityCardMock->series,
                $identityCardMock->number
            );

            $this->assertEquals($humanMock, $human);
        }
    }

    /**
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function testSave(): void
    {
        $humanMock = $this->mockClasses['fizlitco.ts']::createHumanMock();
        $human = $this->humanRepository->findOneById($humanMock->id);

        $oldBirthPlace = $human->birthPlace;

        $human->birthPlace = 'Тестовое место';
        $humanMock->birthPlace = 'Тестовое место';

        $this->humanRepository->save($human);

        $newHuman = $this->humanRepository->findOneById($humanMock->id);
        $this->assertEquals($humanMock, $newHuman);

        $newHuman->birthPlace = $oldBirthPlace;
        $this->humanRepository->save($newHuman);
    }
}
