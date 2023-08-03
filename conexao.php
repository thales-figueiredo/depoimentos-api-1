<?php

$caminhoBanco = __DIR__ . '/banco.sqlite';
$pdo = new PDO('sqlite:' . $caminhoBanco);

echo 'Conectei';

// Verifica se a tabela "depoimentos" já existe no banco de dados
$verificaTabela = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='depoimentos'")->fetchColumn();

if (!$verificaTabela) {
    try {
        // Tenta criar a tabela "depoimentos"
        $pdo->exec('CREATE TABLE depoimentos (id INTEGER PRIMARY KEY, nome TEXT, foto TEXT, depoimento TEXT);');
        echo 'Tabela "depoimentos" criada com sucesso!';
    } catch (PDOException $e) {
        // Caso ocorra um erro ao criar a tabela, imprime a mensagem de erro
        echo 'Erro ao criar a tabela "depoimentos": ' . $e->getMessage();
    }
} else {
    // A tabela "depoimentos" já existe, então pulamos para a próxima etapa
    echo 'Tabela "depoimentos" já existe. Pulando para a próxima etapa...';
}

try {
    // Tenta criar a tabela "destinos"
    $pdo->exec('CREATE TABLE destinos (id INTEGER PRIMARY KEY, nome_destino TEXT, foto_destino TEXT, valor TEXT);');
    echo 'Tabela "destinos" criada com sucesso!';
} catch (PDOException $e) {
    // Caso ocorra um erro ao criar a tabela, imprime a mensagem de erro
    echo 'Erro ao criar a tabela "destinos": ' . $e->getMessage();
}

