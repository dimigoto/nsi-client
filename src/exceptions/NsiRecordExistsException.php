<?php

declare(strict_types=1);

namespace Nsi\exceptions;

use Exception;

/**
 * Class NsiNotFoundException.
 * Данное исключение следует выбрасывать в случае, если НСИ нашла искомую запись.
 */
class NsiRecordExistsException extends Exception
{
}
