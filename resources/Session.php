<?php

namespace Thales\EmissorNF\resources;

class Session
{
    public static function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function get(string $key)
    {
        self::start();
        return $_SESSION[$key] ?? null;
    }

    public static function requireLogin()
    {
        self::start();
        if (!isset($_SESSION['client'])) {
            header('Location: /login');
            exit;
        }
    }

    public static function set(string $key, $value): void
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    public static function destroy(): void
    {
        self::start();
        session_destroy();
    }
}
