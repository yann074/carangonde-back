<?php

return [

    /*
    |----------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |----------------------------------------------------------------------
    |
    | Aqui você pode configurar suas definições de compartilhamento de 
    | recursos entre origens (CORS). Isso determina que operações 
    | entre origens diferentes podem ser executadas em navegadores.
    |
    */
    
    'paths' => ['api/*'],  // Permite para todas as rotas dentro da API
    
    'allowed_methods' => ['*'], // Permite todos os métodos HTTP
    'allowed_origins' => ['https://carangonde-front-production.up.railway.app'], // Permite o frontend específico
    'allowed_origins_patterns' => [], // Pode adicionar padrões de origem se necessário
    'allowed_headers' => ['*'], // Permite todos os cabeçalhos
    'exposed_headers' => [], // Se precisar expor cabeçalhos adicionais
    'max_age' => 0,
    'supports_credentials' => false, // Defina como true se precisar de credenciais (cookies)
];
