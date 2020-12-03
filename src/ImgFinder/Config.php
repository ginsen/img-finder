<?php

declare(strict_types=1);

namespace ImgFinder;

class Config
{
    const TRANSLATORS  = 'translators';
    const REPOSITORIES = 'repositories';

    /** @var iterable */
    private $translates;

    /** @var iterable */
    private $repositories;


    /**
     * @param string $filename
     * @return static
     */
    public static function fromYml(string $filename): self
    {
        $config   = yaml_parse_file($filename);
        $instance = new static();

        $instance->translates   = $config[self::TRANSLATORS];
        $instance->repositories = $config[self::REPOSITORIES];

        return $instance;
    }


    /**
     * @return iterable
     */
    public function getTranslators(): iterable
    {
        return $this->translates;
    }


    /**
     * @return iterable
     */
    public function getRepositories(): iterable
    {
        return $this->repositories;
    }


    private function __construct()
    {
    }
}
