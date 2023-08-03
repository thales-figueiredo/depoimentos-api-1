<?php

namespace Alura\Pdo\Infraestrutura;

use Alura\Pdo\Domain\Model\Depoimentos;
use Alura\Pdo\Domain\Repositorio\RepositorioDepoimento;
use PDO;
class PdoRepositorioDepoimento implements RepositorioDepoimento
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function todosDepoimentos(): array
    {
        $sqlQuery = 'SELECT * FROM depoimentos;';
        $stmt = $this->connection->query($sqlQuery);

        $depoimentosDataList = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $this->hydrateDepoimentosList($depoimentosDataList);
    }

    private function hydrateDepoimentosList(array $depoimentosDataList): array
    {
       // $depoimentosDataList = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $depoimentosList = [];

        foreach ($depoimentosDataList as $depoimentoData) {
            $depoimentosList[] = new Depoimentos(
                $depoimentoData['id'],
                $depoimentoData['nome'],
                $depoimentoData['foto'],
                $depoimentoData['texto_depoimento']
            );
        }

        return $depoimentosList;
    }


    public function salvar(Depoimentos $depoimentos): bool
    {
        if ($depoimentos->id() === null){
            return $this->inserirDepoimento($depoimentos);
        }
        return $this->update($depoimentos);
    }
    public function inserirDepoimento(Depoimentos $depoimentos): bool
    {
        $insertQuery = 'INSERT INTO depoimentos (id, nome, foto, texto_depoimento) VALUES (:id, :nome, :foto, :texto_depoimento);';
        $stmt = $this->connection->prepare($insertQuery);

        $sucesso = $stmt->execute([
            ':id' => $depoimentos->id(),
            ':nome' =>$depoimentos->nome(),
            'foto' => $depoimentos->foto(),
            'texto_depoimento' => $depoimentos->depoimento()
        ]);
        if ($sucesso){
            $depoimentos->defineID($this->connection->lastInsertId());
        }
        return $sucesso;
    }

    public function update(Depoimentos $depoimentos): bool
    {
        $updateQuery = 'UPDATE depoimentos SET nome = :nome, foto = :foto, texto_depoimento = :texto_depoimento WHERE id = :id';
        $stmt = $this->connection->prepare($updateQuery);
        $stmt->bindValue(':nome', $depoimentos->nome());
        $stmt->bindValue(':foto', $depoimentos->foto());
        $stmt->bindValue(':texto_depoimento', $depoimentos->depoimento());
        $stmt->bindValue(':id', $depoimentos->id(), \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deletar(Depoimentos $depoimentos): bool
    {
        $stmt = $this->connection->prepare('DELETE FORM depoimentos WHERE id = ?;');
        $stmt->bindValue(1,$depoimentos->id(), \PDO::PARAM_INT);
        return $stmt->execute();

    }

}