<?php

use Alura\Pdo\Domain\Model\Depoimentos;
use Alura\Pdo\Infraestrutura\PdoRepositorioDepoimento;
use Alura\Pdo\Infraestrutura\Persistencia\ConnectionCreator;

require_once 'vendor/autoload.php';
require_once 'src/Infraestrutura/PdoRepositorioDepoimento.php';

$pdo = ConnectionCreator::CreateConnection();

//$statement = $pdo->query('SELECT * FROM depoimentos;');

//$depoimentosDatalista = $statement->fetchAll(PDO::FETCH_ASSOC);
$repositorioDepoimento = new PdoRepositorioDepoimento($pdo);
$depoimentoLista = $repositorioDepoimento->todosDepoimentos();

//$depoimentoLista = [];
/*
foreach ($depoimentosDatalista as $depoimentoData){
    $depoimentoLista[] = new Depoimentos($depoimentoData['id'],
    $depoimentoData['nome'],
    $depoimentoData['foto'],
    $depoimentoData['texto_depoimento']
    );
}
*/

var_dump($depoimentoLista);






