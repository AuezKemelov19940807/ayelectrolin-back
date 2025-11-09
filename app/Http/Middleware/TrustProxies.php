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
   protected $headers = \Illuminate\Http\Request::HEADER_X_FORWARDED_ALL;
}
