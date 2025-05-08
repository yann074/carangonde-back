<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Laravel CORS Configuration
    |--------------------------------------------------------------------------
    |
    | Here you can configure your settings for Cross-Origin Resource Sharing (CORS).
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'], // Caminhos da sua API para permitir CORS

    'allowed_methods' => ['*'],  // Permite todos os métodos HTTP (GET, POST, etc.)

    'allowed_origins' => [
        'https://carangonde-front-production.up.railway.app', // URL do seu frontend
    ],

    'allowed_headers' => ['*'],  // Permite todos os cabeçalhos HTTP

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true, // Se estiver usando autenticação com cookies
];
