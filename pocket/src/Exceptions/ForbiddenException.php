<?php

namespace Mj\PocketCore\Exceptions;

use Exception;

class  ForbiddenException extends Exception
{
    protected $message = 'Forbidden. (⌐■o■)';
    protected $code = 403;
}