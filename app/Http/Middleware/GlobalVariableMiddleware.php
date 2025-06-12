<?php

namespace App\Http\Middleware;

use App\Services\ServiceImpl\OrganizationServiceImpl;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class GlobalVariableMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $organization = OrganizationServiceImpl::findActive();

        View::share('organization', $organization);

        return $next($request);
    }
}
