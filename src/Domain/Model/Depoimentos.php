<?php

namespace Alura\Pdo\Domain\Model;

class Depoimentos
{
    private ?int $id;
    private string $nome;
    private string $foto;
    private string $texto_depoimento;

    public function __construct(?int $id, string $nome, string $foto, $texto_depoimento)
    {

        $this->id = $id;
        $this->nome = $nome;
        $this->foto = $foto;
        $this->texto_depoimento = $texto_depoimento;

    }

    public function defineID(int $id): void
    {
        if (!is_null($this->id)){
            throw new \DomainException('Você só pode definir o ID uma vez');
        }
        $this->id = $id;
    }

    public function id(): ?int
    {
      return $this->id;
    }

    public function nome(): string
    {
        return $this->nome;
    }

    public function foto(): string
    {
        return $this->foto;
    }

    public function depoimento(): string
    {
        return $this->texto_depoimento;
    }

    public function atualizaDepoimento(string $texto_depoimento): void
    {
        $this->texto_depoimento = $texto_depoimento;
    }
}