<?php

declare(strict_types=1);

namespace Nsi\Tests\mocks;

use Nsi\models\AcademicGroup;
use Nsi\models\CompensationType;
use Nsi\models\Contact;
use Nsi\models\Contractor;
use Nsi\models\Course;
use Nsi\models\Department;
use Nsi\models\EducationForm;
use Nsi\models\EducationProgram;
use Nsi\models\Employee;
use Nsi\models\Human;
use Nsi\models\IdentityCard;
use Nsi\models\IdentityCardKind;
use Nsi\models\Oksm;
use Nsi\models\Student;
use Nsi\models\StudentCategory;
use Nsi\models\StudentStatus;
use Nsi\models\User;

class FizlitcoTsMock extends FizlitcoBaseMock
{
    /**
     * @inheritDoc
     */
    public static function createUserMock(): User
    {
        $result = new User();

        $result->human = static::createHumanMock();
        $result->students[] = static::createStudentMock();
        $result->identityCards[] = static::createIdentityCardMock();

        return $result;
    }

    /**
     * @inheritDoc
     */
    public static function createHumanMock(): Human
    {
        $result = new Human();

        $result->setAnalogs('RTG=00000000-0000-0000-9999-000000000000;OB=00000000-0000-0000-9999-000000000000;EO=00000000-0000-0000-9999-000000000000;IDM=00000000-0000-0000-9999-000000000000');
        $result->setConsistent();

        $result->id = '00000000-0000-0000-9999-000000000000';
        $result->code = '001234567';
        $result->login = 'fizlitco.ts';
        $result->lastNameShort = 'Ф';
        $result->lastName = 'Физлицо';
        $result->firstName = 'Тестовая';
        $result->middleName = 'Студенческая';
        $result->birthPlace = 'пос. Новобурейский';
        $result->birthdate = '1989-12-23';
        $result->basicEmail = 'fizlitco.ts@students.dvfu.ru';
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

        $result->setAnalogs('OB=00000000-0000-0000-aaaa-000000000000');
        $result->setConsistent();

        $result->id = '00000000-0000-0000-aaaa-000000000000';
        $result->period = '2011-12-22';
        $result->series = '1011';
        $result->number = '001234';
        $result->departmentCode = '280-008';
        $result->issuedBy = 'ОТДЕЛОМ УФМС РОССИИ ПО АМУРСКОЙ ОБЛАСТИ В БУРЕЙСКОМ РАЙОНЕ';
        $result->issuedAt = '2011-12-22';
        $result->human = static::createHumanMock();
        $result->documentType = static::createIdentityCardKindMock();

        // Так как НСИ возвращает всего два уровня вложенности моделей, третий уровень возвращает в виде ссылки на
        // сущность необходимо атрибут citizenship у модели human реализовать в виде ссылочной модели
        return static::replaceWithReferenceModels($result);
    }

    /**
     * @inheritDoc
     */
    public static function createStudentMock(): Student
    {
        $result = new Student();

        $result->setAnalogs('OB=00000000-0000-0000-4444-000000000000');
        $result->setConsistent();

        $result->id = '00000000-0000-0000-4444-000000000000';
        $result->gradebookNumber = '012345678';
        $result->entranceYear = '2018';
        $result->isArchive = false;
        $result->privacyNumber = '112018000004317';
        $result->human = static::createHumanMock();
        $result->academicGroup = static::createAcademicGroupMock();
        $result->educationProgram = static::createEducationProgramMock();
        $result->compensationType = static::createCompensationTypeMock();
        $result->course = static::createCourseMock();
        $result->studentCategory = static::createStudentCategoryMock();
        $result->studentStatus = static::createStudentStatusMock();

        return static::replaceWithReferenceModels($result);
    }

    /**
     * @inheritDoc
     */
    public static function createEmployeeMock(): ?Employee
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public static function createContactMock(): ?Contact
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public static function createContractorMock(): ?Contractor
    {
        return null;
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
     * @return AcademicGroup
     */
    public static function createAcademicGroupMock(): AcademicGroup
    {
        $result = new AcademicGroup();

        $result->setAnalogs('OB=89ba96ab-7a74-11e8-a1fb-00155d202c3c;IP=89ba96ab-7a74-11e8-a1fb-00155d202c3c');
        $result->setConsistent(false);

        $result->id = '89ba96ab-7a74-11e8-a1fb-00155d202c3c';
        $result->code = '';
        $result->name = 'Б5106';
        $result->number = '';
        $result->isArchive = false;
        $result->archiveDate = '';
        $result->yearBegin = '';
        $result->yearEnd = '';
        $result->creationDate = '';
//        $result->educationProgram = static::createEducationProgramMock();
//        $result->course = static::createCourseMock();

        return $result;
    }

    /**
     * @return EducationProgram
     */
    public static function createEducationProgramMock(): EducationProgram
    {
        $result = new EducationProgram();

        $result->setConsistent();
        $result->setAnalogs('OB=6e9b0fda-81ba-11e4-1621-bfcb79a0f53f;UKo=6e9b0fda-81ba-11e4-1621-bfcb79a0f53f;IP=6e9b0fda-81ba-11e4-1621-bfcb79a0f53f');
        $result->id = '6e9b0fda-81ba-11e4-1621-bfcb79a0f53f';
        $result->code = '000004';
        $result->name = '58.03.01 Востоковедение и африканистика';
        $result->department = static::createEducationProgramDepartmentMock();
        $result->educationForm = static::createEducationProgramEducationFormMock();

        return static::replaceWithReferenceModels($result);
    }

    /**
     * @return Department
     */
    public static function createEducationProgramDepartmentMock(): Department
    {
        $result = new Department();

        $result->setAnalogs('UKo=f99ef1ce-81ba-11e4-bcbd-00155d201f1f;IP=f99ef1ce-81ba-11e4-bcbd-00155d201f1f');
        $result->setConsistent();

        $result->id = 'f99ef1ce-81ba-11e4-bcbd-00155d201f1f';
        $result->code = '000000217';
        $result->OKATO = '05701000000';
        $result->KPP = '254001001';
        $result->name = 'Восточный институт - Школа региональных и международных исследований';
        $result->isArchive = false;

        return $result;
    }

    /**
     * @return EducationForm
     */
    public static function createEducationProgramEducationFormMock(): EducationForm
    {
        $result = new EducationForm();

        $result->setAnalogs('UKo=cb3c4af3-cdb9-304c-af85-51dc5936572a;IP=cb3c4af3-cdb9-304c-af85-51dc5936572a;OB=cb3c4af3-cdb9-304c-af85-51dc5936572a');
        $result->setConsistent();

        $result->id = 'cb3c4af3-cdb9-304c-af85-51dc5936572a';
        $result->code = '1';
        $result->name = 'Очная';
        $result->nameShort = 'очн';

        return $result;
    }

    /**
     * @return CompensationType
     */
    public static function createCompensationTypeMock(): CompensationType
    {
        $result = new CompensationType();

        $result->setAnalogs('IDM=80b36c09-9004-3949-82bd-af93df3d5d92;OB=80b36c09-9004-3949-82bd-af93df3d5d92;IP=80b36c09-9004-3949-82bd-af93df3d5d92');
        $result->setConsistent();

        $result->id = '80b36c09-9004-3949-82bd-af93df3d5d92';
        $result->code = '2';
        $result->nameShort = 'договор';
        $result->name = 'Полное возмещение затрат';
        $result->group = 'к';

        return $result;
    }

    /**
     * @return StudentStatus
     */
    public static function createStudentStatusMock(): StudentStatus
    {
        $result = new StudentStatus();

        $result->setAnalogs('IP=00506924-aeee-34e9-be6d-71db7149bd8b;UKo=00506924-aeee-34e9-be6d-71db7149bd8b;IDM=00506924-aeee-34e9-be6d-71db7149bd8b;OB=00506924-aeee-34e9-be6d-71db7149bd8b');
        $result->setConsistent();

        $result->id = '00506924-aeee-34e9-be6d-71db7149bd8b';
        $result->code = '1';
        $result->nameShort = 'Уч.';
        $result->name = 'Учится';
        $result->isArchive = false;
        $result->isUseInSystem = false;
        $result->priority = '1';

        return $result;
    }

    /**
     * @return Course
     */
    public static function createCourseMock(): Course
    {
        $result = new Course();

        $result->setAnalogs('OB=36a38b02-9573-3601-9809-1259f0c96c02;IDM=36a38b02-9573-3601-9809-1259f0c96c02;IP=36a38b02-9573-3601-9809-1259f0c96c02');
        $result->setConsistent();

        $result->id = '36a38b02-9573-3601-9809-1259f0c96c02';
        $result->code = '1';
        $result->name = '1';
        $result->number = '1';

        return $result;
    }

    /**
     * @return StudentCategory
     */
    public static function createStudentCategoryMock(): StudentCategory
    {
        $result = new StudentCategory();

        $result->setAnalogs('IDM=c35d3323-a751-307d-a191-b426333c9b17;OB=c35d3323-a751-307d-a191-b426333c9b17;IP=c35d3323-a751-307d-a191-b426333c9b17;UKo=c35d3323-a751-307d-a191-b426333c9b17');
        $result->setConsistent();

        $result->id = 'c35d3323-a751-307d-a191-b426333c9b17';
        $result->code = '1';
        $result->name = 'Студент';

        return $result;
    }
}
