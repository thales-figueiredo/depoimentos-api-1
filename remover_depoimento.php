<?php
use Alura\Pdo\Domain\Model\Depoimentos;

require_once 'vendor/autoload.php';

$pdo = \Alura\Pdo\Infraestrutura\Persistencia\ConnectionCreator::CreateConnection();

$sqlDelete = 'DELETE FORM depoimentos WHERE id = ?';
$prepareStatement = $pdo->prepare($sqlDelete);
$prepareStatement->bindValue(1,2,PDO::PARAM_INT);

var_dump($prepareStatement->execute());






