<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    // public function getUsers();

    // public function getUser($category);

    public function registerUser($request);

    public function loginUser($request);

    // public function logoutUser();

    public function verifyUser($request);
}
