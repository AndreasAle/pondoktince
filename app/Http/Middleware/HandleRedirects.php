<?php

namespace App\Http\Middleware;

use App\Models\Redirect;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class HandleRedirects
{
    public function handle(Request $request, Closure $next): Response
    {
        // Never intercept the admin panel or asset requests.
        $path = '/'.ltrim($request->getPathInfo(), '/');

        if (! str_starts_with($path, '/admin')) {
            $map = Cache::remember('redirects.map', 3600, function () {
                return Redirect::query()->where('is_active', true)
                    ->get(['id', 'old_path', 'new_path', 'status_code'])
                    ->keyBy(fn ($r) => '/'.ltrim($r->old_path, '/'));
            });

            if ($redirect = $map->get($path)) {
                // Best-effort hit counter (won't block the redirect if it fails).
                rescue(fn () => Redirect::whereKey($redirect->id)->increment('hits'), report: false);

                return redirect($redirect->new_path, $redirect->status_code);
            }
        }

        return $next($request);
    }
}
