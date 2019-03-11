<?php

namespace App\Http\Middleware;

use App\Models\Token;
use App\Exceptions\Api\ExpiredTokenException;
use App\Exceptions\Api\InvalidTokenException;
use Closure;
use DateTimeImmutable;

class AccessTokenMiddleware
{
    const ACCESS_TOKEN_HEADER = 'x-access-token';
    const ACCESS_TOKEN_TYPE = 'access';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->headers->has(self::ACCESS_TOKEN_HEADER) && !$request->has(self::ACCESS_TOKEN_HEADER))
        {
            throw new InvalidTokenException;
        }

        $accessToken = $request->header(self::ACCESS_TOKEN_HEADER) ? $request->header(self::ACCESS_TOKEN_HEADER) : $request->get(self::ACCESS_TOKEN_HEADER);

        $token = Token::where('token', $accessToken)
            ->where('type', self::ACCESS_TOKEN_TYPE)
            ->first();

        if (!$token)
        {
            throw new InvalidTokenException;
        }

        $expirationDt = new DateTimeImmutable($token->expire_dt);
        $now = new DateTimeImmutable('now UTC');

        if ($expirationDt < $now)
        {
            throw new ExpiredTokenException;
        }

        $token->expire_dt = $expirationDt->modify('+2 weeks')->format('Y-m-d H:i:s');
        $token->save();

        $request->attributes->add(['authenticated_account' => $token->account]);

        return $next($request);
    }
}
