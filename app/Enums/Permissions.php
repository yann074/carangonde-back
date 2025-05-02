<?php

namespace App\Enums;

enum Permissions: String
{
    case Admin = 'Administrador';

    case Candidate = 'Candidato';

    case User = 'Usuario';
}
