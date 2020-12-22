<?php

declare(strict_types=1);

namespace ImgFinder;

use ImgFinder\Service\RepositoryService;
use ImgFinder\Service\TranslatorService;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Yaml\Yaml;

class Config
{
    const MAIN         = 'img-finder';
    const REPOSITORIES = 'repositories';
    const TRANSLATORS  = 'translators';

    /** @var TranslatorService */
    private $translatorService;

    /** @var RepositoryService */
    private $repositoryService;


    /**
     * @param string                      $filename
     * @param CacheItemPoolInterface|null $cache
     * @return static
     */
    public static function fromYaml(string $filename, CacheItemPoolInterface $cache = null): self
    {
        $config = Yaml::parseFile($filename);
        return self::boostrap($config, $cache);
    }


    /**
     * @param iterable|array              $arr
     * @param CacheItemPoolInterface|null $cache
     * @return Config
     */
    public static function fromArray(iterable $arr, CacheItemPoolInterface $cache = null)
    {
        return self::boostrap($arr, $cache);
    }


    /**
     * @param $config
     * @param CacheItemPoolInterface|null $cache
     * @return Config
     */
    private static function boostrap(iterable $config, ?CacheItemPoolInterface $cache): Config
    {
        $conf = $config[self::MAIN];

        $instance = new static();

        $translators = !empty($conf[self::TRANSLATORS]) ? $conf[self::TRANSLATORS] : [];
        $repositories = !empty($conf[self::REPOSITORIES]) ? $conf[self::REPOSITORIES] : [];

        $instance->translatorService = TranslatorService::init($translators, $cache);
        $instance->repositoryService = RepositoryService::init($repositories, $cache);

        return $instance;
    }


    public function translator(): TranslatorService
    {
        return $this->translatorService;
    }


    public function repository(): RepositoryService
    {
        return $this->repositoryService;
    }


    private function __construct()
    {
    }
}
