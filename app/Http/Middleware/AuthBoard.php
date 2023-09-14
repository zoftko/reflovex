<?php

namespace App\Http\Middleware;

use App\Models\Board;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthBoard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //Assume all requests on this middleware are for api consume
        //Check Authorization header

        if ($request->header('Authorization')) {
            $data = explode(' ', $request->header('Authorization'))[1];
            $uuid = explode(':', $data)[0];
            $board = Board::where('uuid', $uuid)->first();
            if ($board) {
                return $next($request);
            }
        }

        return response()->json([
            'status' => 401,
        ]);

    }
}
