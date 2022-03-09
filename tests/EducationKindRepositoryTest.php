<?php

declare(strict_types=1);

namespace Nsi\Tests;

use Nsi\exceptions\NsiNotFoundException;
use Nsi\exceptions\NsiResponseWithErrorException;
use Nsi\models\EducationForm;
use Nsi\models\EducationKind;
use Nsi\NsiClient;
use Nsi\NsiRequestBuilder;
use Nsi\repository\AcademicGroupRepository;
use Nsi\repository\EducationFormRepository;
use Nsi\repository\EducationKindRepository;
use PHPUnit\Framework\TestCase;
use SoapFault;

class EducationKindRepositoryTest extends TestCase
{
    private EducationKindRepository $educationKindRepository;
    private const WSDL = '';
    private const SOURCE = 'RTG';

    /**
     *
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->educationKindRepository = new EducationKindRepository(
            new NsiClient(static::WSDL),
            new NsiRequestBuilder(static::SOURCE)
        );
    }

    /**
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function testFindOneById(): void
    {
        $result = $this->educationKindRepository->findOneById('e55e3b58-60ef-4006-b0eb-a6fd3c5ec3a0');

        $this->assertEquals(
            'Высшее образование',
            $result->name
        );
    }

    /**
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function testFindAll(): void
    {
        $result = $this->educationKindRepository->findAll();

        $this->assertInstanceOf(EducationKind::class, $result[0]);
    }
}
