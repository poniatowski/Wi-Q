<?php declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(
    __DIR__ . '/../'
);
$dotenv->load();

$builder = new DI\ContainerBuilder();
$container = $builder->build();