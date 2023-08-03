<?php

namespace Alura\Pdo\Domain\Repositorio;

use Alura\Pdo\Domain\Model\Destinos;


interface RepositorioDestinos
{

    public function todosDestinos(): array;

    public function salvarDestinos(Destinos $destinos);

    public function deletarDestinos(Destinos $destinos);

    public function textoDescritivo(Destinos $destinos);
}