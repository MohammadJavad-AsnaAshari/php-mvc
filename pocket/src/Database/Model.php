<?php

namespace Mj\PocketCore\Database;

class Model extends Database
{
    protected string $table;

    public function __construct()
    {
        parent::__construct();
    }
}