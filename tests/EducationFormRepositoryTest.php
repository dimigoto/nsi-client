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
use PHPUnit\Framework\TestCase;
use SoapFault;

class EducationFormRepositoryTest extends TestCase
{
    private EducationFormRepository $educationFormRepository;
    private const WSDL = '';
    private const SOURCE = 'RTG';

    /**
     *
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->educationFormRepository = new EducationFormRepository(
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
        $result = $this->educationFormRepository->findOneById('cb3c4af3-cdb9-304c-af85-51dc5936572a');

        $this->assertEquals(
            'Очная',
            $result->name
        );
    }

    /**
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function testFindAll(): void
    {
        $result = $this->educationFormRepository->findAll();

        $this->assertInstanceOf(EducationForm::class, $result[0]);
    }
}
