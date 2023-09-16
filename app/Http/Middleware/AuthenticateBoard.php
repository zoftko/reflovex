<?php

namespace App\Http\Middleware;

use App\Models\Board;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateBoard
{
    /**
     * Attempt to authenticate the current request with the board's UUID.
     * Credentials must be contained in the Authorization header and follow the basic scheme. As of now
     * both the user and password consist of the board's UID. They must be separated by a colon ':'.
     *
     * E.g: Authorization: Basic myuuid:myuuid
     *
     * @throws AuthenticationException
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authHeader = $request->header('Authorization');
        if (is_null($authHeader)) {
            throw new AuthenticationException();
        }
        if (! str_starts_with($authHeader, 'Basic ')) {
            throw new AuthenticationException();
        }

        $credentials = explode(':', trim(substr($authHeader, 6)));
        if (count($credentials) != 2) {
            throw new AuthenticationException();
        }

        $uuid = $credentials[0];
        $board = Board::where('uuid', $uuid)->first();
        if (! $board) {
            throw new AuthenticationException();
        }

        return $next($request);
    }
}
