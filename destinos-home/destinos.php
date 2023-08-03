<?php


use Alura\Pdo\Infraestrutura\Persistencia\ConnectionCreator;

require_once '../src/Infraestrutura/Persistencia/ConnectionCreator.php';
//funcao para buscar os destinos pelo o nome

function buscarDestinoPorNome($nome): array
{
    $db = ConnectionCreator::CreateConnection();

    $query = "SELECT id AS id, foto_destino As Foto, foto_destino1 AS Foto , nome_destino As Nome, substr(meta, 1, 160) AS Meta, valor AS Preco FROM destinos WHERE nome_destino LIKE :nome";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':nome', "%$nome%");
    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $resultado;
}

//verifica se foi fornecido um nome para a busca do destino
if (!empty($_GET['nome'])){
    //faz a busca do destino
    $destinoEncontrado = buscarDestinoPorNome($_GET['nome']);

    // Caso o destino seja encontrado, retorna o Json
    if(!empty($destinoEncontrado)){
        echo json_encode($destinoEncontrado);
    } else{
        echo json_encode(array("mensagem" => "Nenhum destino encontrado"));
    }
} else json_encode(array("mensagem" => "O destino não foi definido na busca"));
