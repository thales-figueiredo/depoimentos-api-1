<?php

use Alura\Pdo\Domain\Model\Destinos;
use Alura\Pdo\Infraestrutura\PdoRepositorioDestino;
use Alura\Pdo\Infraestrutura\Persistencia\ConnectionCreator;

require_once 'vendor/autoload.php';
require_once 'src/Domain/Model/cors.php';
require_once 'src/OpenAI.php';

$pdo = ConnectionCreator::CreateConnection();

$repositorioDestino = new PdoRepositorioDestino($pdo);

$destino1 = new Destinos(
    null,
    'Maceio',
    'Colocar a foto',
    'Colocar a foto 2 ',
    'escrever os meta tags',
    '',
    2000
);

$destino2 = new Destinos(
    null,
    'Gramado',
    'Colocar a foto',
    'Colocar a foto 2',
    'escrever os meta tags',
    '',
    5000
);

$modeloLinguagem = 'text-davinci-003';

$destino1->defineTextoDescritivo($repositorioDestino->gerarTextoDescritivo($destino1, $modeloLinguagem));
$destino2->defineTextoDescritivo($repositorioDestino->gerarTextoDescritivo($destino2, $modeloLinguagem));



$inseridoComSucesso1 = $repositorioDestino->inserirDestino($destino1);
$inseridoComSucesso2 = $repositorioDestino->inserirDestino($destino2);

if ($inseridoComSucesso1 && $inseridoComSucesso2) {
    echo "Depoimento incluído com sucesso!";
} else {
    echo "Erro ao inserir depoimento.";
}
