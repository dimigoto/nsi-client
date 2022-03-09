<?php

declare(strict_types=1);

namespace Nsi\exceptions;

use Exception;

/**
 * Class NsiResponseWithErrorException
 * Данное исключение выбрасывается в случае, если НСИ возвращает какую-либо ошибку
 */
class NsiResponseWithErrorException extends Exception
{
}
