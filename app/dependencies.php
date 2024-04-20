<?php

declare(strict_types=1);

use App\Shared\Application\Settings\SettingsInterface;
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
            $config->setProxyDir(__DIR__ . '/Proxies');
            $config->setProxyNamespace('Proxies');
            $config->setHydratorDir(__DIR__ . '/Hydrators');
            $config->setHydratorNamespace('Hydrators');
            $config->setDefaultDB('sala');
            $config->setMetadataDriverImpl(AnnotationDriver::create([__DIR__ . '../src/User/Domain',__DIR__ . '../src/Event/Domain']));

            $uri = 'mongodb://localhost:57017';
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
