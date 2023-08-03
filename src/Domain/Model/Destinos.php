<?php

namespace Alura\Pdo\Domain\Model;


class Destinos
{
    private ?int $id;
    private string $nome_destino;
    private string $foto_destino;
    private string $foto_destino1;
    private string $meta;
    private ?string $texto_descritivo;
    private string $valor;

    public function __construct(?int $id, string $nome_destino, string $foto_destino, string $foto_destino1, string $meta, string $texto_descritivo , string $valor)
    {
        $this->id = $id;
        $this->nome_destino = $nome_destino;
        $this->foto_destino = $foto_destino;
        $this->foto_destino1 = $foto_destino1;
        $this->meta = $meta;
        $this->texto_descritivo = $texto_descritivo;
        $this->valor = $valor;
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

    public function nome_destino(): string
    {
        return $this->nome_destino;
    }

    public function foto_destino(): string
    {
        return $this->foto_destino;
    }

    public function foto_destino1(): string
    {
        return $this->foto_destino1;
    }

    public function meta(): string
    {
        return $this->meta;
    }

    public function texto_descritivo(): string
    {
        return $this->texto_descritivo;
    }
    public function valor(): string
    {
        return $this->valor;
    }

    public function defineTextoDescritivo(string $texto_descritivo): void
    {
        $this->texto_descritivo = $texto_descritivo;
    }


}

