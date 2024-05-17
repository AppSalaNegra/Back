<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Swagger;

final class Swagger
{
    public function __construct(
        private readonly string $serverUrl,
        private readonly string $serverDescription,
        private readonly string $configFile
    ) {
    }

    public function get(): string
    {
        $template = file_get_contents(__DIR__ . '/template.html');
        $config          = json_decode(file_get_contents($this->configFile));
        $config->servers = [];
        $config->server  = [
            [
                'url'         => $this->serverUrl,
                'description' => $this->serverDescription
            ]
        ];
        return str_replace('{{spec}}', json_encode($config), $template);
    }
}
