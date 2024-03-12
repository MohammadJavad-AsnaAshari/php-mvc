<?php

namespace Mj\PocketCore;

class Session
{
    protected const FLASH_KEY = '_flash_messages';

    public function __construct()
    {
        session_start();

        $_SESSION[self::FLASH_KEY] = array_map(function ($flashMessage) {
            $flashMessage['remove'] = true;
            return $flashMessage;
        }, $_SESSION[self::FLASH_KEY] ?? []);
    }

    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    public function flash(string $key, mixed $value = null): mixed
    {
        if ($value) {
            $_SESSION[self::FLASH_KEY][$key] = [
                'remove' => false,
                'value' => $value
            ];
        }

        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? null;
    }

    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    private function removeFlashMessages(): void
    {
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        $_SESSION[self::FLASH_KEY] = array_filter($flashMessages, fn($flashMessage) => ! $flashMessage['remove']) ;
    }

    public function __destruct()
    {
        $this->removeFlashMessages();
    }
}