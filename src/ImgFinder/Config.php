<?php

declare(strict_types=1);

namespace ImgFinder;

class Config
{
    const TRANSLATE        = 'translate';
    const DICTIONARY       = 'dictionary';
    const GOOGLE_TRANSLATE = 'google_translate';
    const ENABLE           = 'enable';
    const PATH             = 'path';
    const CREDENTIALS      = 'credentials';
    const REPOSITORIES     = 'repositories';


    /** @var iterable|array */
    private $config;


    /**
     * @param string $filename
     * @return static
     */
    public static function fromYml(string $filename): self
    {
        $instance         = new static();
        $instance->config = yaml_parse_file($filename);

        return $instance;
    }


    /**
     * @return bool
     */
    public function useDictionary(): bool
    {
        return true === @$this->config[self::TRANSLATE][self::DICTIONARY][self::ENABLE];
    }


    /**
     * @return string|null
     */
    public function getDictionaryFilename(): ?string
    {
        if (empty(@$this->config[self::TRANSLATE][self::DICTIONARY][self::PATH])) {
            return null;
        }

        return $this->config[self::TRANSLATE][self::DICTIONARY][self::PATH];
    }


    /**
     * @return bool
     */
    public function useGoogleTranslate(): bool
    {
        return true === @$this->config[self::TRANSLATE][self::GOOGLE_TRANSLATE][self::ENABLE];
    }


    /**
     * @return iterable|null
     */
    public function getCredentialsGoogleTranslate(): ?iterable
    {
        if (empty(@$this->config[self::TRANSLATE][self::GOOGLE_TRANSLATE][self::CREDENTIALS])) {
            return null;
        }

        return $this->config[self::TRANSLATE][self::GOOGLE_TRANSLATE][self::CREDENTIALS];
    }


    /**
     * @return array
     */
    public function getRepositories(): iterable
    {
        if (empty($this->config[self::REPOSITORIES])) {
            return [];
        }

        return $this->config[self::REPOSITORIES];
    }


    /**
     * @param string $name
     * @return iterable|null
     */
    public function getRepository(string $name): ?iterable
    {
        if (empty($this->config[self::REPOSITORIES][$name])) {
            return null;
        }

        return $this->config[self::REPOSITORIES][$name];
    }


    private function __construct()
    {
    }
}
