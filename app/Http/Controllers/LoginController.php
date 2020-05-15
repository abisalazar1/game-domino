<?php
namespace App\Http\Controllers;

use App\Services\Api\TokenService;
use App\Http\Requests\LoginRequest;
use App\Repositories\UserRepository;

class LoginController extends Controller
{
    /**
     * Login Request
     *
     * @param TokenService $tokenService
     * @param LoginRequest $request
     * @param UserRepository $userRepository
     *
     * @return void
     */
    public function store(
        TokenService $tokenService,
        LoginRequest $request,
        UserRepository $userRepository
    ) {
        $user = $userRepository->findByUsername($request->username);

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
