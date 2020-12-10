<?php

declare(strict_types=1);

namespace ImgFinder;

use ImgFinder\Service\RepositoryService;
use ImgFinder\Service\TranslatorService;
use Psr\Cache\CacheItemPoolInterface;

class Config
{
    const MAIN         = 'img-finder';
    const REPOSITORIES = 'repositories';
    const TRANSLATORS  = 'translators';

    /** @var TranslatorService */
    private $translator;

    /** @var RepositoryService */
    private $imgRepo;


    /**
     * @param string $filename
     * @param CacheItemPoolInterface|null $cache
     * @return static
     */
    public static function fromYaml(string $filename, CacheItemPoolInterface $cache = null): self
    {
        $config = yaml_parse_file($filename);
        $conf   = $config[self::MAIN];

        $instance = new static();

        $translators  = !empty($conf[self::TRANSLATORS]) ? $conf[self::TRANSLATORS] : [];
        $repositories = !empty($conf[self::REPOSITORIES]) ? $conf[self::REPOSITORIES] : [];

        $instance->translator = TranslatorService::init($translators, $cache);
        $instance->imgRepo    = RepositoryService::init($repositories, $cache);

        return $instance;
    }


    public function translator(): TranslatorService
    {
        return $this->translator;
    }


    public function repository(): RepositoryService
    {
        return $this->imgRepo;
    }


    private function __construct()
    {
    }
}
