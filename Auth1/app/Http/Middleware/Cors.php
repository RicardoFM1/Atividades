<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    public function handle($request, Closure $next)
    {
        if ($request->isMethod('OPTIONS')) {
            return response()->json('', 200)
                ->header('Access-Control-Allow-Origin', ['http://localhost:5173', 'http://localhost:3000'])
                ->header('Access-Control-Allow-Headers', 'Authorization, Content-Type')
                ->header('Access-Control-Allow-Methods', 'OPTIONS, GET, POST, PUT, PATCH, DELETE')
                ->header('Access-Control-Allow-Credentials', true);
        }

        $reponse = $next($request);

        return $reponse
            ->header('Access-Control-Allow-Origin', ['http://localhost:5173', 'http://localhost:3000'])
            ->header('Access-Control-Allow-Headers', 'Authorization, Content-Type')
            ->header('Access-Control-Allow-Methods', 'OPTIONS, GET, POST, PUT, PATCH, DELETE')
            ->header('Access-Control-Allow-Credentials', true);
    }
}
