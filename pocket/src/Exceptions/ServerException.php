<?php

namespace Mj\PocketCore\Exceptions;

use Exception;

class ServerException extends Exception
{
    protected $message = 'Server Error! (╯°□°）╯';
    protected $code = 500;

}