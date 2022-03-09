<?php

declare(strict_types=1);

namespace Nsi\exceptions;

use Exception;

/**
 * Class NsiNotFoundException.
 * Данное исключение следует выбрасывать в случае, если НСИ не нашла искомую запись.
 */
class NsiNotFoundException extends Exception
{
}
