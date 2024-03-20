<?php

namespace Mj\PocketCore\Exceptions;

use Exception;

class NotFoundException extends Exception
{
    protected $message = 'Not Found! ¯\_(ツ)_/¯';
    protected $code = 404;

}