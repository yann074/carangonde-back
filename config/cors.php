<?php

return [
    'paths' => ['*'], // Permite todos os caminhos
    
    'allowed_methods' => ['*'], // Permite todos os métodos HTTP
    'allowed_origins' => ['*'], // Permite todas as origens
    'allowed_origins_patterns' => [], 
    'allowed_headers' => ['*'], // Permite todos os cabeçalhos
    'exposed_headers' => [],
    'max_age' => 0, // Desabilita cache de preflight
    'supports_credentials' => false, // Deve ser false quando permitir *
];