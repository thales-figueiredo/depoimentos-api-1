<?php

namespace Alura\Pdo\Infraestrutura;

use Alura\Pdo\Domain\Model\Destinos;
use Alura\Pdo\Domain\Repositorio\RepositorioDestinos;
use OpenAI;
use PDO;
class PdoRepositorioDestino implements RepositorioDestinos
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function todosDestinos(): array
    {
        $sqlQuery = 'SELECT * FROM destinos;';
        $stmt = $this->connection->query($sqlQuery);

        return $this->hydrateDestinolista($stmt);
    }

    private function hydrateDestinoLista(\PDOStatement $stmt): array
    {
        $destinoDataLista = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $destinoLista = [];

        foreach ($destinoDataLista as $destinoData) {
            $destinoLista[] = new Destinos(
                $destinoData['id'],
                $destinoData['nome_destino'],
                $destinoData['foto_destino'],
                $destinoData['foto_destino1'],
                $destinoData['texto_descritivo'],
                $destinoData['meta'],
                $destinoData['valor']
            );
        }
        return $destinoLista;
    }

    public function salvarDestinos(Destinos $destinos): bool
    {
        if ($destinos->id() === null){
            return $this->inserirDestino($destinos);
        }
        return $this->update($destinos);
    }

    public function inserirDestino(Destinos $destinos): bool
    {
        $insertQuery = 'INSERT INTO destinos (id,nome_destino,foto_destino,foto_destino1,texto_descritivo,meta,valor ) VALUES (:id, :nome_destino, :foto_destino, :foto_destino1, :texto_desritivo ,:meta, :valor);';
        $stmt = $this->connection->prepare($insertQuery);

        $sucesso = $stmt->execute([
            ':id'=> $destinos->id(),
            ':nome_destino'=> $destinos->nome_destino(),
            ':foto_destino'=> $destinos->foto_destino(),
            ':foto_destino1'=> $destinos->foto_destino1(),
            ':meta'=> $destinos->meta(),
            ':texto_descritivo'=> $destinos->texto_descritivo(),
            ':valor'=> $destinos->valor()
        ]);
        if ($sucesso){
            $destinos->defineID($this->connection->lastInsertId());
        }

        return $sucesso;
    }

    public function update(Destinos $destinos): bool
    {
        $updateQuery = 'UPDATE destinos SET nome_destino = :nome_destino, foto_destino = :foto_destino, foto_destino1 = :foto_destino1, 
                         texto_descritivo = :texto_descritivo, meta = :meta, valor = :valor WHERE id = :id';
        $stmt = $this->connection->prepare($updateQuery);
        $stmt->bindValue(':nome_destino', $destinos->nome_destino());
        $stmt->bindValue(':foto_destino', $destinos->foto_destino());
        $stmt->bindValue('foto_destino1', $destinos->foto_destino1());
        $stmt->bindValue('meta', $destinos->meta());
        $stmt->bindValue(':valor', $destinos->valor());
        $stmt->bindValue(':texto_descritivo', $destinos->texto_descritivo());
        $stmt->bindValue(':id', $destinos->id(), PDO::PARAM_INT);
        return $stmt->execute();

    }

    public function deletarDestinos(Destinos $destinos): bool
    {
        $stmt = $this->connection->prepare('DELETE FROM destinos WHERE id = ?;');
        $stmt->bindValue(1,$destinos->id(), PDO::PARAM_INT);
        return $stmt->execute();

    }

    public function gerarTextoDescritivo(Destinos $destinos, string $model): string
    {
        $openAI = new \Alura\Pdo\OpenAI();
        if (empty($destinos->texto_descritivo())) {
            return $openAI->complete("Faça um resumo sobre '{$destinos->nome_destino()}' enfatizando o porquê este
             lugar é incrível. Utilize uma linguagem informal e até 100 caracteres no máximo em cada parágrafo. Crie 2 
             parágrafos neste resumo.",['model'=> $model ]);
        } else {
            return $destinos->texto_descritivo();
        }
    }

    public function textoDescritivo(Destinos $destinos): ?string
    {
        $sqlQuery = 'SELECT texto_descritivo FROM destinos WHERE id = :id;';
        $stmt = $this->connection->prepare($sqlQuery);
        $stmt->bindValue(':id', $destinos->id(), PDO::PARAM_INT);
        $stmt->execute();
        $textoDescritivo = $stmt->fetchColumn();

        return $textoDescritivo !== false ? $textoDescritivo : null;
    }




}