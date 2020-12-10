<?php

declare(strict_types=1);

namespace Tests;

use ImgFinder\Config;
use ImgFinder\Service\RepositoryService;
use ImgFinder\Service\TranslatorService;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_make_config_instance()
    {
        $yaml   = __DIR__ . '/../doc/examples/config.yml';
        $config = Config::fromYaml($yaml);

        self::assertInstanceOf(Config::class, $config);
        self::assertInstanceOf(RepositoryService::class, $config->repository());
        self::assertInstanceOf(TranslatorService::class, $config->translator());
    }


    /**
     * @test
     */
    public function it_should_return_repository_names()
    {
        $yaml   = __DIR__ . '/../doc/examples/config.yml';
        $config = Config::fromYaml($yaml);

        self::assertSame(['spy-repository'], $config->repositoryNames());
    }
}
