<?php
namespace App\Http\Middleware;

use App\Services\SubscriptionService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckActiveCompanySubscription
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && ! SubscriptionService::hasActiveSubscription($user)) {
            session()->put('url.intended', $request->url());
            return redirect()->route('subscription.required');
        }

        return $next($request);
    }
}
