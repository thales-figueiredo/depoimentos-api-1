<?php

namespace Alura\Pdo\Infraestrutura\Persistencia;

use PDO;
class ConnectionCreator
{
    public static function CreateConnection(): PDO
    {
        $databsePath = __DIR__ . '/../../../banco.sqlite';

        return new PDO('sqlite:' . $databsePath);
    }

}