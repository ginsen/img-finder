<?php

declare(strict_types=1);

namespace ImgFinder;

use ImgFinder\Repository\RepositoryService;
use ImgFinder\Translate\TranslatorService;
use Psr\Cache\CacheItemPoolInterface;

class Config
{
    const MAIN         = 'img-finder';
    const TRANSLATORS  = 'translators';
    const REPOSITORIES = 'repositories';

    /** @var TranslatorService */
    private $translator;

    /** @var RepositoryService */
    private $imgRepo;

    /** @var CacheItemPoolInterface|null */
    private $cache = null;


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



    /**
     * @return TranslatorService
     */
    public function getTranslator(): TranslatorService
    {
        return $this->translator;
    }


    /**
     * @return RepositoryService
     */
    public function getRepository(): RepositoryService
    {
        return $this->imgRepo;
    }


    private function __construct()
    {
    }
}
