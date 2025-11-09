<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    protected $proxies = '*'; // доверяем всем прокси
    protected $headers = Request::HEADER_X_FORWARDED_ALL;
}