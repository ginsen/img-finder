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

    /** @var int */
    private $widthSmall;

    /** @var string|null */
    private $repository;

    /** @var Slugify */
    private $slugify;


    /**
     * {@inheritDoc}
     */
    public static function set(
        string $words,
        int $page = 1,
        int $perPage = 10,
        string $orientation = 'landscape',
        int $widthSmall = 320,
        string $repository = null
    ): RequestInterface {
        $instance = new static();

        $instance->words       = $words;
        $instance->page        = $page;
        $instance->perPage     = $perPage;
        $instance->orientation = $orientation;
        $instance->widthSmall  = $widthSmall;
        $instance->repository  = $repository;

        return $instance;
    }


    public function setWords(string $words): RequestInterface
    {
        return self::set(
            $words,
            $this->page(),
            $this->perPage(),
            $this->orientation(),
            $this->widthSmall(),
            $this->repository()
        );
    }


    public function setPage(int $page): RequestInterface
    {
        return self::set(
            $this->words(),
            $page,
            $this->perPage(),
            $this->orientation(),
            $this->widthSmall(),
            $this->repository()
        );
    }


    public function setPerPage(int $perPage): RequestInterface
    {
        return self::set(
            $this->words(),
            $this->page(),
            $perPage,
            $this->orientation(),
            $this->widthSmall(),
            $this->repository()
        );
    }


    public function setOrientation(string $orientation): RequestInterface
    {
        return self::set(
            $this->words(),
            $this->page(),
            $this->perPage(),
            $orientation,
            $this->widthSmall(),
            $this->repository()
        );
    }


    public function setWidthSmall(int $width): RequestInterface
    {
        return self::set(
            $this->words(),
            $this->page(),
            $this->perPage(),
            $this->orientation(),
            $width,
            $this->repository()
        );
    }


    public function setRepository(?string $repository): RequestInterface
    {
        return self::set(
            $this->words(),
            $this->page(),
            $this->perPage(),
            $this->orientation(),
            $this->widthSmall(),
            $repository
        );
    }


    public function words(): string
    {
        return $this->words;
    }


    public function urlWords(): string
    {
        return urlencode($this->words);
    }


    public function slugWords(): string
    {
        return $this->slugify->slugify($this->words);
    }


    public function hasRepository(): bool
    {
        return null !== $this->repository;
    }


    public function repository(): ?string
    {
        return $this->repository;
    }


    public function page(): int
    {
        return $this->page;
    }


    public function perPage(): int
    {
        return $this->perPage;
    }


    public function orientation(): string
    {
        return $this->orientation;
    }


    public function widthSmall(): int
    {
        return $this->widthSmall;
    }


    public function isEqual(RequestInterface $request): bool
    {
        return $this === $request;
    }


    public function cacheKey(): string
    {
        return sprintf(
            '%s-%d-%d-%s-%d',
            $this->orientation(),
            $this->perPage(),
            $this->widthSmall(),
            $this->slugWords(),
            $this->page()
        );
    }


    private function __construct()
    {
        $this->slugify = new Slugify();
    }
}
