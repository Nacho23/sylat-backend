<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\UserRol;
use App\Models\Account;
use App\Exceptions\Api\AuthorizationException;
use App\Exceptions\Api\ResourceNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class to handle access token requests
 */
class AccessTokenController extends ApiController
{
    /**
     * Exchange an access token for the related credentials
     *
     * @return Response
     */
    public function postCollection(Request $request) : Response
    {
        $this->verify($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $account = Account::authenticate($request->get('email'), $request->get('password'));

        $user = User::where('email', $request->get('email'))->firstOrFail();

        $userRol = UserRol::where('user_id', $user->id)->first();

        if (!$userRol)
        {
            throw new AuthorizationException;
        }

        return $this->respond([
            'access_token' => $account->refreshAccessToken()->token,
            'user' => [
                'account_uuid' => $account->uuid,
                'user_uuid' => $user->uuid,
                'rol' => $userRol->rol->name,
                'unit_id' => $user->unit_id,
                'user_id' => $user->id,
            ],
        ]);
    }

    /**
     * Delete (expire) the given token
     *
     * @return Response
     */
    public function deleteResource(Request $request, $hash) : Response
    {
        $account = $request->get('authenticated_user');

        $token = $account->getTokenByHash($hash);

        if (!$token)
        {
            throw new ResourceNotFoundException('Account token ' . $hash);
        }

        if ($token->account_id !== $account->id)
        {
            throw new AuthorizationException;
        }

        $account->expireTokens();

        return $this->respond([]);
    }

    /**
     * Verify that the token exists and is correct
     *
     * @return Response
     */
    public function getResource(Request $request, $hash) : Response
    {
        $token = $request->get('authenticated_account')->getTokenByHash($hash);

        if (!$token)
        {
            throw new ResourceNotFoundException('Account token ' . $hash);
        }

        $account = $token->account;

        $user = User::where('email', $account->email)->firstOrFail();

        $userRol = UserRol::where('user_id', $user->id)->firstOrFail();

        return $this->respond([
            'access_token' => $request->get('authenticated_account')->refreshAccessToken()->token,
            'rol' => $userRol->rol->name,
            'unit_id' => $user->unit_id,
        ]);
    }
}
