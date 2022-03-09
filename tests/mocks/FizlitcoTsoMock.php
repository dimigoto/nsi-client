<?php

declare(strict_types=1);

namespace Nsi\Tests\mocks;

use Nsi\models\Contact;
use Nsi\models\ContactKind;
use Nsi\models\Contractor;
use Nsi\models\Department;
use Nsi\models\Employee;
use Nsi\models\Grade;
use Nsi\models\Human;
use Nsi\models\IdentityCard;
use Nsi\models\IdentityCardKind;
use Nsi\models\Oksm;
use Nsi\models\Organization;
use Nsi\models\Post;
use Nsi\models\Student;
use Nsi\models\User;

class FizlitcoTsoMock extends FizlitcoBaseMock
{
    /**
     * @inheritDoc
     */
    public static function createUserMock(): User
    {
        $result = new User();

        $result->human = static::createHumanMock();
        $result->employers[] = static::createEmployeeMock();
        $result->contractors[] = static::createContractorMock();
        $result->contacts[] = static::createContactMock();
        $result->identityCards[] = static::createIdentityCardMock();

        return $result;
    }

    /**
     * @inheritDoc
     */
    public static function createHumanMock(): Human
    {
        $result = new Human();

        $result->setAnalogs('EO=00000000-0000-0000-bbbb-000000000000;IDM=00000000-0000-0000-bbbb-000000000000;RTG=00000000-0000-0000-bbbb-000000000000;OB=00000000-0000-0000-bbbb-000000000000');
        $result->setConsistent();

        $result->id = '00000000-0000-0000-bbbb-000000000000';
        $result->code = '000012345';
        $result->login = 'fizlitco.tso';
        $result->lastNameShort = 'Ф';
        $result->lastName = 'Физлицо';
        $result->firstName = 'Тестовая';
        $result->middleName = 'Сотрудническая';
        $result->birthPlace = 'пос. Новобурейский';
        $result->birthdate = '1990-01-02';
        $result->basicEmail = 'fizlitco.tso@dvfu.ru';
        $result->pfr = '';
        $result->gender = 'Женский';
        $result->citizenship = static::createCitizenshipOksmMock();

        return $result;
    }

    /**
     * @inheritDoc
     */
    public static function createIdentityCardMock(): IdentityCard
    {
        $result = new IdentityCard();

        $result->setAnalogs('OB=00000000-0000-0000-cccc-000000000000');
        $result->setConsistent();

        $result->id = '00000000-0000-0000-cccc-000000000000';
        $result->period = '2012-01-03';
        $result->series = '1012';
        $result->number = '000012';
        $result->departmentCode = '280-008';
        $result->issuedBy = 'ОТДЕЛОМ УФМС РОССИИ ПО АМУРСКОЙ ОБЛАСТИ В БУРЕЙСКОМ РАЙОНЕ';
        $result->issuedAt = '2012-01-03';
        $result->human = static::createHumanMock();
        $result->documentType = static::createIdentityCardKindMock();

        return static::replaceWithReferenceModels($result);
    }

    /**
     * @inheritDoc
     */
    public static function createStudentMock(): ?Student
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public static function createEmployeeMock(): ?Employee
    {
        $result = new Employee();

        $result->setAnalogs('OB=00000000-0000-0000-5555-000000000000');
        $result->setConsistent();

        $result->id = '00000000-0000-0000-5555-000000000000';
        $result->code = 'Ф1234567';
        $result->contractType = 'Трудовой договор';
        $result->employmentType = 'Основное место работы';
        $result->rate = '0.75';
        $result->employmentDate = '2018-09-06';
        $result->dischargeDate = '';
        $result->organization = static::createOrganizationMock();
        $result->organizationOPID = static::createOrganizationMock();
        $result->human = static::createHumanMock();
        $result->department = static::createEmployeeDepartmentMock();
        $result->post = static::createPostMock();
        $result->grade = static::createGradeMock();

        return static::replaceWithReferenceModels($result);
    }

    /**
     * @inheritDoc
     */
    public static function createContactMock(): ?Contact
    {
        $result = new Contact();

        $result->setAnalogs('');
        $result->setConsistent();

        $result->id = 'e1be018f-1075-4dcf-a399-5f22acf7780f';
        $result->type = 'Телефон';
        $result->description = '8 000 790 00 11';
        $result->field1 = '1';
        $result->field2 = '2';
        $result->field3 = '3';
        $result->field4 = '';
        $result->field5 = '';
        $result->field6 = '';
        $result->field7 = '';
        $result->field8 = '';
        $result->field9 = '';
        $result->field10 = '';
        $result->comment = '1';
        $result->isDefault = false;
        $result->kind = static::createContactKind();
        $result->human = static::createHumanMock();

        return static::replaceWithReferenceModels($result);
    }

    /**
     * @inheritDoc
     */
    public static function createContractorMock(): ?Contractor
    {
        $result = new Contractor();

        $result->setAnalogs('');
        $result->setConsistent();

        $result->id = '00000000-0000-0000-1234-000000000000';
        $result->code = 'TEST1234';
        $result->nameFull = 'Физлицо Тестовая Сотрудническая';
        $result->type = 'Физическое лицо';
        $result->human = static::createHumanMock();

        return static::replaceWithReferenceModels($result);
    }

    /**
     * @return Oksm
     */
    public static function createCitizenshipOksmMock(): Oksm
    {
        $result = new Oksm();

        $result->setAnalogs('UKo=982d33e2-bee6-453a-992e-11d13fa66fa7;RTG=982d33e2-bee6-453a-992e-11d13fa66fa7;IP=982d33e2-bee6-453a-992e-11d13fa66fa7;OB=982d33e2-bee6-453a-992e-11d13fa66fa7;UPI=982d33e2-bee6-453a-992e-11d13fa66fa7;UKu=982d33e2-bee6-453a-992e-11d13fa66fa7;BU=982d33e2-bee6-453a-992e-11d13fa66fa7');
        $result->setConsistent(false);

        $result->id = '982d33e2-bee6-453a-992e-11d13fa66fa7';
        $result->code = '643';
        $result->nameShort = 'РОССИЯ';
        $result->nameFull = 'Российская Федерация';

        return $result;
    }

    /**
     * @return IdentityCardKind
     */
    public static function createIdentityCardKindMock(): IdentityCardKind
    {
        $result = new IdentityCardKind();

        $result->setAnalogs('BU=ffeceef4-bc4c-4076-8ea7-03636eb00fbb;UKu=ffeceef4-bc4c-4076-8ea7-03636eb00fbb;UKo=ffeceef4-bc4c-4076-8ea7-03636eb00fbb;RTG=ffeceef4-bc4c-4076-8ea7-03636eb00fbb;OB=ffeceef4-bc4c-4076-8ea7-03636eb00fbb;UPI=ffeceef4-bc4c-4076-8ea7-03636eb00fbb;IP=ffeceef4-bc4c-4076-8ea7-03636eb00fbb');
        $result->setConsistent();

        $result->id = 'ffeceef4-bc4c-4076-8ea7-03636eb00fbb';
        $result->code = '0';
        $result->name = 'Паспорт гражданина Российской Федерации';
        $result->IFNS = '21';
        $result->PFR = 'ПАСПОРТ РОССИИ';

        return $result;
    }

    /**
     * @return Organization
     */
    public static function createOrganizationMock(): Organization
    {
        $result = new Organization();

        $result->setAnalogs('UKo=988bf31c-619a-11e0-a335-001a4be8a71c;BU=988bf31c-619a-11e0-a335-001a4be8a71c;OB=988bf31c-619a-11e0-a335-001a4be8a71c');
        $result->setConsistent();

        $result->id = '988bf31c-619a-11e0-a335-001a4be8a71c';
        $result->code = '000001';
        $result->name = 'Дальневосточный федеральный университет';
        $result->prefix = 'ДФУ';
        $result->INN = '2536014538';
        $result->IFNS = '2540';
        $result->OPF = '75101';
        $result->KFS = '12';
        $result->OKATO = '05701000';
        $result->OKVED = '80.3';
        $result->OKPO = '02067942';
        $result->OKONH = '92100';
        $result->PFR = '035-008';
        $result->KPP = '254001001';
        $result->IMNS = 'Инспекция Федеральной налоговой службы по Фрунзенскому  району города Владивостока';
        $result->OKOPF = 'Автономные учреждения';
        $result->nameFSS = 'Филиал № 3 Государственного учреждения - Приморского регионального отделения Фонда социального страхования Российской Федерации';
        $result->nameFull = 'Федеральное государственное автономное образовательное учреждение высшего образования  Дальневосточный федеральный университет ';
        $result->nameShort = 'ДВФУ';
        $result->OGRN = '1022501297785';
        $result->regPFR = '035-008-082011';
        $result->regFSS = '2503362290';

        return $result;
    }

    /**
     * @return Grade
     */
    public static function createGradeMock(): Grade
    {
        $result = new Grade();

        $result->setAnalogs('OB=0dce22af-adc1-11e5-8203-00155d203226;UKo=0dce22af-adc1-11e5-8203-00155d203226');
        $result->setConsistent();

        $result->id = '0dce22af-adc1-11e5-8203-00155d203226';
        $result->code = '000001074';
        $result->name = '247 / ПКГ-3 / КУ-5-6(ВБ)';

        return $result;
    }

    /**
     * @return Department
     */
    public static function createEmployeeDepartmentMock(): Department
    {
        $result = new Department();

        $result->setAnalogs('UKo=81850fb3-6396-11e8-acf8-00155d203d40;OB=81850fb3-6396-11e8-acf8-00155d203d40');
        $result->setConsistent();

        $result->id = '81850fb3-6396-11e8-acf8-00155d203d40';
        $result->code = 'ШР_ШБМ_04_47';
        $result->OKATO = '05701000000';
        $result->KPP = '254001001';
        $result->name = 'Отдел академического маркетинга и медицинской аккредитации (Архив)';
        $result->isArchive = false;

        $result->head = new Human();
        $result->head->setAnalogs('UPI=839f4e6a-ddaa-480e-ba15-30904afa7a6b;OB=839f4e6a-ddaa-480e-ba15-30904afa7a6b;BU=839f4e6a-ddaa-480e-ba15-30904afa7a6b;RTG=839f4e6a-ddaa-480e-ba15-30904afa7a6b;UKo=839f4e6a-ddaa-480e-ba15-30904afa7a6b');
        $result->head->setConsistent();
        $result->head->id = '839f4e6a-ddaa-480e-ba15-30904afa7a6b';

        $result->organization = static::createOrganizationMock();

        $result->parent = new Department();
        $result->parent->setAnalogs('OB=774f9590-ea14-4559-b710-531ef324799c;UPI=774f9590-ea14-4559-b710-531ef324799c;IP=774f9590-ea14-4559-b710-531ef324799c;BU=774f9590-ea14-4559-b710-531ef324799c;UKo=774f9590-ea14-4559-b710-531ef324799c');
        $result->parent->setConsistent();
        $result->parent->id = '774f9590-ea14-4559-b710-531ef324799c';

        return $result;
    }

    /**
     * @return Post
     */
    public static function createPostMock(): Post
    {
        $result = new Post();

        $result->setAnalogs('OB=857ccb99-c5b4-42ce-bf4e-768e4d49dbf7;UKo=857ccb99-c5b4-42ce-bf4e-768e4d49dbf7');
        $result->setConsistent();

        $result->id = '857ccb99-c5b4-42ce-bf4e-768e4d49dbf7';
        $result->code = 'TU00101';
        $result->name = 'Главный специалист';
        $result->isAUP = false;
        $result->statisticalServiceCategory = 'Руководители';
        $result->isFlyingCrew = false;

        return $result;
    }

    /**
     * @return ContactKind
     */
    public static function createContactKind(): ContactKind
    {
        $result = new ContactKind();

        $result->setAnalogs('UKo=8b05b832-c05c-11e7-8b8d-00155d203d40;IP=8b05b832-c05c-11e7-8b8d-00155d203d40;OB=8b05b832-c05c-11e7-8b8d-00155d203d40');
        $result->setConsistent();

        $result->id = '8b05b832-c05c-11e7-8b8d-00155d203d40';
        $result->code = '00025';
        $result->name = 'Телефон мобильный (1)';
        $result->type = 'Телефон';
        $result->object = 'Справочник  Физические лица ';

        return $result;
    }
}
