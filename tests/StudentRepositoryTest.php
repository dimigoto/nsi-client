<?php

declare(strict_types=1);

namespace Nsi\Tests;

use Nsi\exceptions\NsiNotFoundException;
use Nsi\exceptions\NsiResponseWithErrorException;
use Nsi\NsiClient;
use Nsi\NsiRequestBuilder;
use Nsi\repository\StudentRepository;
use Nsi\Tests\mocks\FizlitcoBaseMock;
use Nsi\Tests\mocks\FizlitcoTsMock;
use PHPUnit\Framework\TestCase;
use SoapFault;

class StudentRepositoryTest extends TestCase
{
    private StudentRepository $studentRepository;
    private const WSDL = '';
    private const SOURCE = 'RTG';
    private const HUMAN_GUID = '00000000-0000-0000-9999-000000000000';
    private const STUDENT_GUID = '00000000-0000-0000-4444-000000000000';
    private const GRADEBOOK_NUMBER = '012345678';

    /**
     * @var FizlitcoBaseMock[]
     */
    private array $mockClasses;


    /**
     * @throws SoapFault
     */
    protected function setUp(): void
    {
        parent::setUp();

        ini_set('default_socket_timeout', '1000');

        $this->studentRepository = new StudentRepository(
            new NsiClient(static::WSDL,
                  [
                      'connection_timeout' => 1000
                  ]
            ),
            new NsiRequestBuilder(static::SOURCE)
        );

        $this->mockClasses = [
            'fizlitco.ts' => FizlitcoTsMock::class
        ];
    }

    /**
     * Тест на поиск студента по идентификатору
     *
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function testFindOneById(): void
    {
        foreach ($this->mockClasses as $mockClass) {
            $studentMock = $mockClass::createStudentMock();
            $student = $this->studentRepository->findOneById($studentMock->id);

            $this->assertEquals($studentMock, $student);
        }

    }

    /**
     * Тест на поиск студента информации по идентификатору физлица
     *
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function testFindAllByHumanId(): void
    {
        foreach ($this->mockClasses as $mockClass) {
            $studentMock = $mockClass::createStudentMock();
            $students = $this->studentRepository->findAllByHumanId($studentMock->human->id);

            $this->assertEquals($studentMock, $students[0]);
        }
    }
}
