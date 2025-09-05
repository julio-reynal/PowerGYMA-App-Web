<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Force HTTPS Configuration
    |--------------------------------------------------------------------------
    |
    | This configuration determines if the application should force HTTPS
    | connections and redirect all HTTP requests to HTTPS.
    |
    */

    'enabled' => env('FORCE_HTTPS', false),
    
    /*
    |--------------------------------------------------------------------------
    | HTTPS in Production
    |--------------------------------------------------------------------------
    |
    | Automatically enable HTTPS forcing in production environment
    |
    */
    
    'production_only' => env('FORCE_HTTPS_PRODUCTION_ONLY', true),
    
    /*
    |--------------------------------------------------------------------------
    | Trust Proxies
    |--------------------------------------------------------------------------
    |
    | Railway and other cloud providers use proxies
    |
    */
    
    'trust_proxies' => env('TRUST_PROXIES', '*'),
];
