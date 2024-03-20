<?php

namespace Mj\PocketCore\Validation\Rules;

use Mj\PocketCore\Database\Model;
use Rakit\Validation\Rule;

class ExistsRule extends Rule
{
    protected $message = ":attribute :value is not exists";

    protected $fillableParams = ['table', 'column'];

    public function check($value): bool
    {
        // make sure required parameters exists
        $this->requireParameters(['table', 'column']);

        // getting parameters
        $column = $this->parameter('column');
        $table = $this->parameter('table');

        $data = (new Model())->from($table)->where($column, $value)->first();

        return !!$data;
    }
}