<?php

declare(strict_types=1);

namespace Nsi\Tests;

use Nsi\exceptions\NsiNotFoundException;
use Nsi\exceptions\NsiResponseWithErrorException;
use Nsi\models\Course;
use Nsi\NsiClient;
use Nsi\NsiRequestBuilder;
use Nsi\repository\CourseRepository;
use PHPUnit\Framework\TestCase;

class CourseRepositoryTest extends TestCase
{
    private CourseRepository $courseRepository;
    private const WSDL = '';
    private const SOURCE = 'RTG';

    /**
     *
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->courseRepository = new CourseRepository(
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
        $result = $this->courseRepository->findOneById('36a38b02-9573-3601-9809-1259f0c96c02');

        $this->assertEquals(
            '1',
            $result->number
        );
    }

    /**
     * @throws NsiNotFoundException
     * @throws NsiResponseWithErrorException
     */
    public function testFindAll(): void
    {
        $result = $this->courseRepository->findAll();

        $this->assertInstanceOf(Course::class, $result[0]);
    }
}
