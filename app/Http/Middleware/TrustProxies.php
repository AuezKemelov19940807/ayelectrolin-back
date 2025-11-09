<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * Доверенные прокси. '*' = все.
     */
    protected $proxies = '*';

    /**
     * Заголовки, которые учитывать.
     */
    protected $headers = Request::HEADER_X_FORWARDED_FOR |
                         Request::HEADER_X_FORWARDED_HOST |
                         Request::HEADER_X_FORWARDED_PROTO |
                         Request::HEADER_X_FORWARDED_PORT;

    public function handle(Request $request, \Closure $next)
    {
        // Логируем протокол для проверки
        \Log::info('Scheme detected: ' . $request->getScheme());
        \Log::info('Is secure? ' . ($request->isSecure() ? 'yes' : 'no'));
        \Log::info('X-Forwarded-Proto: ' . $request->header('X-Forwarded-Proto'));

        return parent::handle($request, $next);
    }
}
