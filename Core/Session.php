<?php

namespace App\Core;

class Session
{
    const STATUS_SUCCESS = 'success';
    const STATUS_ERROR = 'error';
    const STATUS_WARNING = 'warning';

    private mixed $flash;

    public function __construct()
    {
        session_start();

        $this->flash = $_SESSION['flashes'] ?? [];

        foreach ($this->flash as $key => $message) {
            $this->flash[$key]['remove'] = true;
        }

        $this->insertIntoSession();
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        return $_SESSION[$key] ?? false;
    }

    public function pull($key)
    {
        $sessionValue = $_SESSION[$key] ?? false;

        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }

        return $sessionValue;
    }

    public function remove($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public function setFlash($key, $msg)
    {
        $this->flash[$key] = [
            'remove' => false,
            'message' => $msg,
        ];

        $this->insertIntoSession();
    }

    public function getFlash($key)
    {
        return $this->flash[$key]['message'] ?? false;
    }

    protected function insertIntoSession()
    {
        $_SESSION['flashes'] = $this->flash;
    }

    public function __destruct()
    {
        foreach ($this->flash as $key => $message) {
            if ($this->flash[$key]['remove']){
                unset($this->flash[$key]);
            }
        }

        $this->insertIntoSession();
    }
}
