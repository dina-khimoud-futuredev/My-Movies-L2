<?php

namespace mdb;

class Logger
{
    private $mdb;

    public function __construct()
    {
        $this->mdb = new MoviesDB();
    }

    public function log(string $username, string $password): array
    {
        $error = null;
        $granted = false;
        $user=null;

        if (empty($username)) {
            $error = "Username is empty";
        } elseif (empty($password)) {
            $error = "Password is empty";
        } else {
            $user = $this->mdb->checkUser($username);
            if ($user && password_verify($password, $user->password)) {
                $granted = true;
            } else {
                $error = "Authentication failed";
            }
        }

        return [
            'granted' => $granted,
            'error' => $error,
            'user'=>$user
        ];
    }

    public function signup(string $username, string $password): array
    {
        $error = null;
        $signed = false;

        if (empty($username)) {
            $error = "Username is empty";
        } elseif (empty($password)) {
            $error = "Password is empty";
        } else {
            $user = $this->mdb->checkUser($username);

            if ($user) {
                $error = "User already exists";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $result = $this->mdb->signup($username, $hashedPassword);
                if ($result) {
                    $signed = true;
                } else {
                    $error = "Sign up failed";
                }
            }
        }

        return [
            'signed' => $signed,
            'error' => $error
        ];
    }
}
