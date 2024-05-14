<?php

namespace Mj\PocketCore\Exceptions;

use Exception;

class NotMatchMiddleware extends Exception
{
    public function __construct($key)
    {
        $this->message = "No matching middleware found for key '{$key}'.";
        $this->code = 400;
    }
}