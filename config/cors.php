<?php

return [
    'paths' => ['api/*', 'sanctum/cstf-cookie'], // Permite todos os caminhos
    
    'allowed_methods' => ['GET', 'POST', 'DELETE', 'PUT'], // Permite todos os métodos HTTP
    'allowed_origins' => ['*'], // Permite todas as origens
    'allowed_origins_patterns' => [], 
    'allowed_headers' => ['Content-Type', 'Authorization'], // Permite todos os cabeçalhos
    'exposed_headers' => [],
    'max_age' => 3600, // Desabilita cache de preflight
    'supports_credentials' => true, // Deve ser false quando permitir *
];