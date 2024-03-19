<?php

namespace Mj\PocketCore;

use Rakit\Validation\Validation;
use Rakit\Validation\Validator;

class Controller
{
    protected function validate(array $data, array $rules, array $message = []): Validation
    {
        $validator = new Validator($message);

        // make it
        $validation = $validator->make($data, $rules);

        // validate
        $validation->validate();

        if ($validation->fails()) {
            response()->withErrors($validation->errors);
        }

        return $validation;
    }

    public function render(string $view, array $data = []): string
    {
        return (new View)->render($view, $data);
    }
}