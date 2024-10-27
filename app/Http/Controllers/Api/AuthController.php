<?php

namespace App\Http\Controllers\Api;

use App\Events\NewUser;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Http\Requests\Auth\VerifyUserRequest;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use App\Traits\ConvertNamingConventions;
use App\Traits\RandomCode;

class AuthController extends BaseController
{
    use RandomCode, ConvertNamingConventions;

    public $user_repository;

    public function __construct(UserRepository $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    public function register(RegisterUserRequest $request)
    {
        $user = $this->user_repository->registerUser($request->validated());

        $code = $this->generateRandomNumber(6);
        $user->update(['verification_code' => $code]);

        $message['user'] = UserResource::make($user);
        $message['token'] = $user->createToken($request->userAgent())->plainTextToken;

        event(new NewUser($user, $code));

        return $this->sendResponse($message, 201);
    }

    public function login(LoginUserRequest $request)
    {
        $user = $this->user_repository->loginUser($request->validated());

        if (empty($user))
            return $this->sendResponse("Unauthorized.", 401, "Fail");

        if (empty($user->phone_number_verified_at)) {
            $code = $this->generateRandomNumber(6);
            $user->update(['verification_code' => $code]);
            event(new NewUser($user, $code));
        }

        $message['user'] = UserResource::make($user);
        $message['token'] = $user->createToken($request->userAgent())->plainTextToken;

        return $this->sendResponse($message);
    }

    public function verifyCode(VerifyUserRequest $request)
    {
        if ($this->user_repository->verifyUser($request->validated()))
            return $this->sendResponse("User verified successfully");

        return $this->sendResponse('Invalid verification code', 400, 'Fail');
    }
}
