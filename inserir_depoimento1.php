<?php

use Alura\Pdo\Domain\Model\Depoimentos;
use Alura\Pdo\Infraestrutura\PdoRepositorioDepoimento;
use Alura\Pdo\Infraestrutura\Persistencia\ConnectionCreator;

require_once 'vendor/autoload.php';
require_once 'src/Domain/Model/cors.php';

$pdo = ConnectionCreator::CreateConnection();

$repositorioDepoimento = new PdoRepositorioDepoimento($pdo);

$depoimento1 = new Depoimentos(
    null,
    'Thales Figueiredo',
    'Nao sei colocar foto',
    'Esse é o teste de depoimento '
);

$depoimento2 = new Depoimentos(
    null,
    'Bianca Melo',
    'Nao sei colocar foto 2',
    'Fui em Caldas Novas e lembrei de vc !'
);

$inseridoComSucesso1 = $repositorioDepoimento->inserirDepoimento($depoimento1);
$inseridoComSucesso2 = $repositorioDepoimento->inserirDepoimento($depoimento2);

if ($inseridoComSucesso1 && $inseridoComSucesso2) {
    echo "Depoimento incluído com sucesso!";
} else {
    echo "Erro ao inserir depoimento.";
}


