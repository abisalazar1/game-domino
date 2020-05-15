<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use App\Services\Api\TokenService;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Creates a new user
     *
     * @param RegisterUserRequest $request
     * @param UserRepository $userRepository
     *
     * @return JsonResponse
     */
    public function store(
        TokenService $tokenService,
        RegisterUserRequest $request,
        UserRepository $userRepository
    ) {
        $user = $userRepository->create($request->only([
            'username',
            'password'
        ]));

        $data = array_merge(
            ['data' => [
            'id' => $user->id,
            'username' => $user->username,
        ]],
            $tokenService->createToken($user->username, $request->password)
        );

        return \response()->json($data);
    }
}
