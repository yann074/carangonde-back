<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação de E-mail</title>
</head>
<body>
    <h2>Olá, {{ $user->name }}!</h2>
    <p>Obrigado por se cadastrar. Para confirmar seu e-mail, clique no link abaixo:</p>
    <p>
        <a href="{{ $link }}" style="display: inline-block; padding: 10px 15px; background-color: #28a745; color: #fff; text-decoration: none; border-radius: 5px;">
            Confirmar E-mail
        </a>
    </p>
    <p>Se você não solicitou este cadastro, ignore este e-mail.</p>
</body>
</html>