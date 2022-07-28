<?php

namespace app\users\entities;


class AuthorizationInfo
{
private string $password;
private string $mail;

    /**
     * @param string $password
     * @param string $mail
     */
    public function __construct(string $password, string $mail)
    {
        $this->password = $password;
        $this->mail = $mail;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getMail(): string
    {
        return $this->mail;
    }
}