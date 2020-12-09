<?php

declare(strict_types=1);

namespace ImgFinder;

use Cocur\Slugify\Slugify;

class Request implements RequestInterface
{
    /** @var string */
    private $words;

    /** @var int */
    private $page;

    /** @var int */
    private $perPage;

    /** @var string */
    private $orientation;

    /** @var Slugify */
    private $slugify;


    public static function set(
        string $words,
        int $page = 1,
        int $perPage = 10,
        string $orientation = 'landscape'
    ): RequestInterface {
        $instance = new static();

        $instance->words       = $words;
        $instance->page        = $page;
        $instance->perPage     = $perPage;
        $instance->orientation = $orientation;

        return $instance;
    }


    public function setWords(string $words): RequestInterface
    {
        return self::set(
            $words,
            $this->getPage(),
            $this->getPerPage(),
            $this->getOrientation()
        );
    }


    public function setPage(int $page): RequestInterface
    {
        return self::set(
            $this->getWords(),
            $page,
            $this->getPerPage(),
            $this->getOrientation()
        );
    }


    public function setPerPage(int $perPage): RequestInterface
    {
        return self::set(
            $this->getWords(),
            $this->getPage(),
            $perPage,
            $this->getOrientation()
        );
    }


    public function setOrientation(string $orientation): RequestInterface
    {
        return self::set(
            $this->getWords(),
            $this->getPage(),
            $this->getPerPage(),
            $orientation
        );
    }


    public function getWords(): string
    {
        return $this->words;
    }


    public function getUrlWords(): string
    {
        return urlencode($this->words);
    }


    public function getSlugWords(): string
    {
        return $this->slugify->slugify($this->words);
    }


    public function getPage(): int
    {
        return $this->page;
    }


    public function getPerPage(): int
    {
        return $this->perPage;
    }


    public function getOrientation(): string
    {
        return $this->orientation;
    }


    public function isEqual(RequestInterface $request): bool
    {
        return $this === $request;
    }


    public function getCacheKey(): string
    {
        return sprintf(
            '%s-%d-%s-%d',
            $this->getOrientation(),
            $this->getPerPage(),
            $this->getSlugWords(),
            $this->getPage()
        );
    }


    private function __construct()
    {
        $this->slugify = new Slugify();
    }
}
