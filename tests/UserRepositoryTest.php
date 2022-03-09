<?php

declare(strict_types=1);

namespace Nsi\Tests;

use Nsi\exceptions\NsiNotFoundException;
use Nsi\exceptions\NsiResponseWithErrorException;
use Nsi\NsiClient;
use Nsi\NsiRequestBuilder;
use Nsi\repository\UserRepository;
use Nsi\Tests\mocks\FizlitcoBaseMock;
use Nsi\Tests\mocks\FizlitcoTsMock;
use Nsi\Tests\mocks\FizlitcoTsoMock;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{
    private UserRepository $userRepository;
    private const WSDL = '';
    private const SOURCE = 'RTG';

    /**
     * @var FizlitcoBaseMock[]
     */
    private array $mockClasses;


    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepository = new UserRepository(
            new NsiClient(static::WSDL),
            new NsiRequestBuilder(static::SOURCE)
        );

        $this->mockClasses = [
            'fizlitco.ts' => FizlitcoTsMock::class,
            'fizlitco.tso' => FizlitcoTsoMock::class,
        ];
    }

    /**
     * Тест на поиск пользователя по идентификатору физлица
     *
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function testFindOneByHumanId(): void
    {
        foreach ($this->mockClasses as $mockClass) {
            $userMock = $mockClass::createUserMock();
            $user = $this->userRepository->findOneByHumanId($userMock->human->id);

            $this->assertEquals($userMock, $user);
        }
    }
}
