<?php

namespace Mj\PocketCore;

class Response
{
    public function redirect(string $url): self
    {
        header("Location: $url");

        return $this;
    }
}