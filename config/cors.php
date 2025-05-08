<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie', 'login', 'logout'],
    
    'allowed_methods' => ['*'],
    'allowed_origins' => ['https://carangonde-front-production.up.railway.app'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 86400,
    'supports_credentials' => true, // Importante para autenticação
];