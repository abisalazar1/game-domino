<?php

namespace App\Services\Api;

use Illuminate\Support\Facades\DB;
use App\Exceptions\AuthorisationException;

class TokenService
{
    /**
     * Username && password
     *
     * @param string $username
     * @param string $password
     *
     * @return array
     */
    public function createToken(string $username, string $password)
    {
        return $this->sendRequest([
            'grant_type' => 'password',
            'username' => $username,
            'password' => $password,
        ]);
    }

    /**
     * Refresh a token
     *
     * @param string|null $refreshToken
     *
     * @return array
     */
    public function retrieveToken(?string $refreshToken = '')
    {
        return $this->sendRequest([
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
        ]);
    }

    /**
     * Cookie
     *
     * @param array $token
     *
     * @return void
     */
    public function getRefreshCookie(array $token)
    {
        return cookie(
            config('session.cookie_refresh_token_name'),
            $token['token']['refresh_token'],
            60 * 24 * 10,
            null,
            config('session.domain'),
            config('session.secure'),
            true
        );
    }

    /**
     * Gets the token
     *
     * @param array $extraOptions
     * @param int $id
     *
     * @return void
     */
    private function sendRequest(array $extraOptions = [], int $id = 2)
    {
        $client = $this->getClient($id);

        $request = app('request')->create('/oauth/token', 'POST', array_merge([
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'scope' => '*'
        ], $extraOptions));

        $response = json_decode(
            app('router')->prepareResponse(
                $request,
                app()->handle($request)
            )->content(),
            true
        );
  
        if (isset($response['error'])) {
            throw new AuthorisationException('Invalid Credentials');
        }

        return ['token' => $response];
    }

    /**
     * Gets the client
     *
     * @param int $name
     *
     * @return Object
     */
    private function getClient(int $id)
    {
        return DB::table('oauth_clients')->select('id', 'secret')->where('id', $id)->first();
    }
}
