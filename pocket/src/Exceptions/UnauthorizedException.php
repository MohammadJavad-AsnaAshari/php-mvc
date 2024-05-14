<?php

namespace Mj\PocketCore\Exceptions;

use Exception;

class  UnauthorizedException extends Exception
{
    protected $message = 'Unauthorized. (⌐■_■)';
    protected $code = 401;
}