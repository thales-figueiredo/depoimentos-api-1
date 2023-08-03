<?php

use Alura\Pdo\Domain\Model\Depoimentos;
use Alura\Pdo\Infraestrutura\PdoRepositorioDepoimento;
use Alura\Pdo\Infraestrutura\Persistencia\ConnectionCreator;

require_once '../src/Domain/Model/cors.php';
require_once '../vendor/autoload.php';
require_once '../src/Infraestrutura/PdoRepositorioDepoimento.php';

$pdo = ConnectionCreator::CreateConnection();

$repositorioDepoimento = new PdoRepositorioDepoimento($pdo);
$depoimentoLista = $repositorioDepoimento->todosDepoimentos();


shuffle($depoimentoLista);

$depoimentoExibicao = array_slice($depoimentoLista,0 ,3);
/*
// Bufferizar a saída para evitar problemas com os cabeçalhos
ob_start();

//header('Content-Type: application/json');
echo json_encode($depoimentoExibicao);

// Limpar o buffer e enviar a saída para o navegador
ob_end_flush();
*/
//var_dump($depoimentoExibicao);

// Iniciar o buffer para armazenar a saída em HTML
ob_start();

// Criar a estrutura HTML
echo '<html>';
echo '<head>';
echo '<title>Depoimentos</title>';
echo '</head>';
echo '<body>';
echo '<h1>Depoimentos</h1>';

// Exibir cada depoimento em uma div
foreach ($depoimentoLista as $depoimento) {
    echo '<div>';
    echo '<h2>ID: ' . $depoimento->id() . '</h2>';
    echo '<p>Nome: ' . $depoimento->nome() . '</p>';
    echo '<p>Foto: ' . $depoimento->foto() . '</p>';
    echo '<p>Texto: ' . $depoimento->depoimento() . '</p>';
    echo '</div>';
}

// Fechar a estrutura HTML
echo '</body>';
echo '</html>';

// Obter a saída do buffer e limpar o buffer
$html = ob_get_clean();

// Definir o cabeçalho como HTML
header('Content-Type: text/html');

// Exibir o HTML na página
echo $html;