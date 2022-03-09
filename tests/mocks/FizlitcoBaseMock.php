<?php

declare(strict_types=1);

namespace Nsi\Tests\mocks;

use Nsi\models\Contact;
use Nsi\models\Contractor;
use Nsi\models\Employee;
use Nsi\models\Human;
use Nsi\models\IdentityCard;
use Nsi\models\NsiModel;
use Nsi\models\Student;
use Nsi\models\User;

abstract class FizlitcoBaseMock
{
    /**
     * @return User
     */
    abstract public static function createUserMock(): User;

    /**
     * @return Human
     */
    abstract public static function createHumanMock(): Human;

    /**
     * @return IdentityCard
     */
    abstract public static function createIdentityCardMock(): IdentityCard;

    /**
     * @return Student|null
     */
    abstract public static function createStudentMock(): ?Student;

    /**
     * @return Employee|null
     */
    abstract public static function createEmployeeMock(): ?Employee;

    /**
     * @return Contact|null
     */
    abstract public static function createContactMock(): ?Contact;

    /**
     * @return Contractor|null
     */
    abstract public static function createContractorMock(): ?Contractor;

    /**
     * Метод заменяет вложенные модели в 3-м уровне вложения на ссылочные модели
     *
     * @param $model
     * @param int $level
     *
     * @return mixed
     */
    protected static function replaceWithReferenceModels($model, int $level = 0)
    {
        $attributes = get_object_vars($model);

        foreach ($attributes as $key => $attribute) {
            if ($model->$key instanceof NsiModel) {
                if ($level === 1) {
                    $model->$key = static::createReferenceModel($attribute);
                } else {
                    $model->$key = static::replaceWithReferenceModels($attribute, $level + 1);
                }
            }
        }

        return $model;
    }

    /**
     * Создаёт ссылочную модель из обычной
     *
     * @param mixed $model
     *
     * @return NsiModel
     */
    protected static function createReferenceModel($model): NsiModel
    {
        /** @var NsiModel $className */
        $className = get_class($model);

        $result = $className::fromSimpleXMLElement(
            simplexml_load_string(
                sprintf(
                    '<%s><ID>%s</ID></%s>',
                    $className::getEntityName(),
                    $model->id,
                    $className::getEntityName()
                )
            )
        );

        $result->setAnalogs($model->getAnalogs());
        $result->setConsistent(!$model->isNotConsistent());

        return $result;
    }
}
