<?php

namespace app\core;

class Session
{
    public function __construct()
    {
        session_start();
        $flashMessages = $_SESSION['flash_messages'] ?? [];

        foreach ($flashMessages as &$flashMessage){
            $flashMessage['remove'] = true;
        }
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        return $_SESSION[$key] ?? false;
    }

    public function setFlash($key, $message)
    {
        $_SESSION['flash_messages'][$key] = ['message' =>$message, 'remove' => false];
    }

    public function getFlash($key)
    {
        return $_SESSION['flash_messages'][$key] ?? null;
    }

    public function __destruct()
    {
        $flashMessages = $_SESSION['flash_messages'] ?? [];

        foreach ($flashMessages as $key => &$flashMessage){
            if($flashMessage['remove']){
                unset($flashMessage[$key]);
            }
        }

        $_SESSION['flash_messages'] = $flashMessages;
    }
}
