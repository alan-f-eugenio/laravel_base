<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StripEmptyParams {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        $query = request()->query();
        $querycount = count($query);
        foreach ($query as $key => $value) {
            if ($value == '') {
                unset($query[$key]);
            }
        }
        if ($querycount > count($query)) {
            $path = url()->current() . (!empty($query) ? '/?' . http_build_query($query) : '');

            return redirect()->to($path);
        }

        return $next($request);
    }
}
