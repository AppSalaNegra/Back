<?php

declare(strict_types=1);

use App\Shared\Domain\AppConstants;
use App\Shared\Infrastructure\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;
use MongoDB\Client;
use MongoDB\Driver\ServerApi;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

/*
 * Aquí se definen las dependencias que el contenedor no puede levantar por sí mismo.
 * En esta clase defino el DocumentManager de Doctrine y el Logger de Monolog.
 * */
return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        DocumentManager::class => function (ContainerInterface $c) {
            $config = new Configuration();
            $config->setProxyDir('../src/Shared/Infrastructure/Proxies');
            $config->setProxyNamespace('Proxies');
            $config->setHydratorDir('../src/Shared/Infrastructure/Doctrine');
            $config->setHydratorNamespace('Hydrators');
            $config->setDefaultDB(AppConstants::$DEFAULT_DB);
            $config->setMetadataDriverImpl(
                AnnotationDriver::create([__DIR__ . '../src/Users/Domain', __DIR__ . '../src/Events/Domain'])
            );
            $uri = AppConstants::$DB_HOST . AppConstants::$DB_USER . AppConstants::$DB_PASS . AppConstants::$DB_CONFIG;
            $apiVersion = new ServerApi((string)ServerApi::V1);
            $options = [
                'serverApi' => $apiVersion,
                'typeMap' => DocumentManager::CLIENT_TYPEMAP,
            ];
            $client = new Client($uri, [], $options);

            return DocumentManager::create($client, $config);
        },
    ]);
};
