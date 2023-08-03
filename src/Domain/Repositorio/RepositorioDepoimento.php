<?php

namespace Alura\Pdo\Domain\Repositorio;

use Alura\Pdo\Domain\Model\Depoimentos;

interface RepositorioDepoimento
{
    public function todosDepoimentos(): array;

    public function salvar(Depoimentos $depoimentos): bool;

    public function deletar(Depoimentos $depoimentos): bool;



}