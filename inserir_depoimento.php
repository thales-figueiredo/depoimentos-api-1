<?php

use Alura\Pdo\Domain\Model\Depoimentos;
use Alura\Pdo\Infraestrutura\Persistencia\ConnectionCreator;

require_once 'vendor/autoload.php';

$pdo = ConnectionCreator::CreateConnection();

$depoimento = new Depoimentos(
    null,
    'Thales Figueiredo',
    'nao sei como colocar foto',
    'esse é o teste do meu depoimento '
);
$sqlInsert = 'INSERT INTO depoimentos (id, nome, foto, texto_depoimento) VALUES (:id, :nome, :foto,:texto_depoimento);';
$statement = $pdo->prepare($sqlInsert);
$statement->bindValue(':id', $depoimento->id());
$statement->bindValue(':nome', $depoimento->nome());
$statement->bindValue(':foto', $depoimento->foto());
$statement->bindValue(':texto_depoimento', $depoimento->depoimento());

if ($statement->execute()) {
    echo "Depoimento Incluido com sucesso!";
}






