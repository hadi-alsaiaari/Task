<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function registerUser($data)
    {
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
    }

    public function loginUser($data)
    {
        $user = User::where('phone_number', $data['phone_number'])->first();
        if ($user && Hash::check($data['password'], $user->password))
            return $user;
        return null;
    }

    public function verifyUser($data)
    {
        $user = User::findOrFail($data['user_id']);

        if ($user->verification_code != $data['code'])
            return false;

        $user->update(['phone_number_verified_at' => now()]);
        return true;
    }
}
