<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Exceptions;
use CodeIgniter\Filters\ForceHTTPS;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\PageCache;
use CodeIgniter\Filters\PerformanceMetrics;
use CodeIgniter\Shield\Filters\AuthenticationFilter;
use CodeIgniter\Shield\Filters\ChainAuthenticationFilter;
use CodeIgniter\Shield\Filters\SessionAuthenticationFilter;

class Filters extends BaseConfig
{
    public $aliases = [
        'csrf'      => CSRF::class,
        'toolbar'   => DebugToolbar::class,
        'honeypot'  => \CodeIgniter\Honeypot\Honeypot::class,
        'invalidchars' => InvalidChars::class,
        'secureheaders' => \CodeIgniter\Security\SecureHeaders::class,
        'pagecache' => PageCache::class,
        'performance' => PerformanceMetrics::class,
        'debug' => DebugToolbar::class,
        'auth' => SessionAuthenticationFilter::class,
        'noauth' => \App\Filters\NoAuthFilter::class,
    ];

    public $globals = [
        'before' => [
            'invalidchars',
            'secureheaders',
            'csrf' => ['except' => ['api/*']],
        ],
        'after' => [
            'toolbar',
            'pagecache',
            'performance',
        ],
    ];
}
