<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * Доверять всем прокси (в Railway это обязательно!)
     *
     * @var array<int, string>|string|null
     */
    protected $proxies = '*';

    /**
     * Использовать все заголовки X-Forwarded-* для определения схемы.
     *
     * @var int
     */
    protected $headers = Request::HEADER_X_FORWARDED_FOR
                       | Request::HEADER_X_FORWARDED_HOST
                       | Request::HEADER_X_FORWARDED_PORT
                       | Request::HEADER_X_FORWARDED_PROTO
                       | Request::HEADER_X_FORWARDED_AWS_ELB;
}
