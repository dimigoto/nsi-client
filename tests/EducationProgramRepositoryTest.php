<?php

declare(strict_types=1);

namespace Nsi\Tests;

use Nsi\exceptions\NsiNotFoundException;
use Nsi\exceptions\NsiResponseWithErrorException;
use Nsi\models\EducationForm;
use Nsi\NsiClient;
use Nsi\NsiRequestBuilder;
use Nsi\repository\AcademicGroupRepository;
use Nsi\repository\EducationFormRepository;
use Nsi\repository\EducationProgramRepository;
use PHPUnit\Framework\TestCase;
use SoapFault;

class EducationProgramRepositoryTest extends TestCase
{
    private EducationProgramRepository $educationProgramRepository;
    private const WSDL = '';
    private const SOURCE = 'RTG';

    private const EDUCATION_PROGRAM_GUID = 'dcf2c9dd-89b6-3e71-b13d-c99c60a21b19';

    /**
     *
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->educationProgramRepository = new EducationProgramRepository(
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
        $result = $this->educationProgramRepository->findOneById(static::EDUCATION_PROGRAM_GUID);

        $this->assertEquals(
            '4118',
            $result->code
        );
    }
}
