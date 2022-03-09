<?php

declare(strict_types=1);

namespace Nsi\Tests;

use Nsi\NsiRequest;
use Nsi\NsiRequestBuilder;
use Nsi\Tests\mocks\FizlitcoTsoMock;
use PHPUnit\Framework\TestCase;
use SoapVar;

class NsiRequestBuilderTest extends TestCase
{
    private array $valuesToUpdateResult;

    protected function setUp(): void
    {
        parent::setUp();

        $this->valuesToUpdateResult = [
            'ID' => '00000000-0000-0000-bbbb-000000000000',
            'HumanID' => '000012345',
            'HumanLogin' => 'fizlitco.tso',
            'HumanLastNameShort' => 'Ф',
            'HumanLastName' => 'Физлицо',
            'HumanFirstName' => 'Тестовая',
            'HumanMiddleName' => 'Сотрудническая',
            'HumanBirthdate' => '1990-01-02',
            'HumanBasicEmail' => 'fizlitco.tso@dvfu.ru',
            'HumanPFR' => '',
            'HumanBirthPlace' => 'пос. Новобурейский',
            'HumanSex' => 'Женский',
            'HumanCitizenship' => [
                'Oksm' => [
                    'ID' => '982d33e2-bee6-453a-992e-11d13fa66fa7',
                    'OksmID' => '643',
                    'OksmNameShort' => 'РОССИЯ',
                    'OksmNameFull' => 'Российская Федерация',
                ]
            ]
        ];
    }

    /**
     *
     */
    public function testUpdateModel(): void
    {
        $human = FizlitcoTsoMock::createHumanMock();

        $nsiRequestBuilder = new NsiRequestBuilder('RTG');
        $result = $nsiRequestBuilder->updateModel($human);
        $valuesToUpdateResult = $this->valuesToUpdateResult;

        $valuesToUpdateResult['HumanCitizenship']['Oksm'] = [
            'ID' => $this->valuesToUpdateResult['HumanCitizenship']['Oksm']['ID']
        ];

        $this->assertEquals(
            $valuesToUpdateResult,
            $result->getDatagram()->getValuesToUpdateForEntity($human::getEntityName())
        );
    }

    /**
     *
     */
    public function testUpdateModelLevel1(): void
    {
        $human = FizlitcoTsoMock::createHumanMock();

        $nsiRequestBuilder = new NsiRequestBuilder('RTG');
        $result = $nsiRequestBuilder->updateModel($human, 1);
        $valuesToUpdateResult = $this->valuesToUpdateResult;

        $this->assertEquals(
            $valuesToUpdateResult,
            $result->getDatagram()->getValuesToUpdateForEntity($human::getEntityName())
        );
    }

    /**
     *
     */
    public function testBuildDatagramAsArray(): void
    {
        $nsiRequestBuilder = new NsiRequestBuilder('RTG');
        $nsiRequestBuilder->update('Entity', ['test' => 'testValue'], ['ID' => 'test']);

        $buildDatagramResult = [
            [
                'Entity' => [
                    'ID' => 'test',
                    'test' => 'testValue'
                ]
            ]
        ];

        $this->assertEquals(
            $buildDatagramResult,
            $nsiRequestBuilder->buildDatagramAsArray()
        );
    }

    /**
     *
     */
    public function testBuildRequest(): void
    {
        $nsiRequestBuilder = new NsiRequestBuilder('RTG');
        $nsiRequestBuilder->update('Entity', ['test' => 'testValue'], ['ID' => 'test']);

        $requestResult = new NsiRequest();
        $requestResult->setDatagramFromArray(
            [
                'Entity' => [
                    'ID' => 'test',
                    'test' => 'testValue',
                ]
            ]
        );
        $requestResult->setRoutingHeader('update', 'RTG', '1');

        $this->assertEquals(
            $requestResult,
            $nsiRequestBuilder->buildRequest('1')
        );
    }
}
