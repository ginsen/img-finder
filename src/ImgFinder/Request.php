<?php

declare(strict_types=1);

namespace ImgFinder;

use Cocur\Slugify\Slugify;

class Request implements RequestInterface
{
    /** @var string */
    private $words;

    /** @var string|null */
    private $repository;

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
        string $repository = null,
        int $page = 1,
        int $perPage = 10,
        string $orientation = 'landscape'
    ): RequestInterface {
        $instance = new static();

        $instance->words       = $words;
        $instance->repository  = $repository;
        $instance->page        = $page;
        $instance->perPage     = $perPage;
        $instance->orientation = $orientation;

        return $instance;
    }


    public function setWords(string $words): RequestInterface
    {
        return self::set(
            $words,
            $this->repository(),
            $this->page(),
            $this->perPage(),
            $this->orientation()
        );
    }

    public function setRepository(?string $repository): RequestInterface
    {
        return self::set(
            $this->words(),
            $repository,
            $this->page(),
            $this->perPage(),
            $this->orientation()
        );
    }


    public function setPage(int $page): RequestInterface
    {
        return self::set(
            $this->words(),
            $this->repository(),
            $page,
            $this->perPage(),
            $this->orientation()
        );
    }


    public function setPerPage(int $perPage): RequestInterface
    {
        return self::set(
            $this->words(),
            $this->repository(),
            $this->page(),
            $perPage,
            $this->orientation()
        );
    }


    public function setOrientation(string $orientation): RequestInterface
    {
        return self::set(
            $this->words(),
            $this->repository(),
            $this->page(),
            $this->perPage(),
            $orientation
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


    public function isEqual(RequestInterface $request): bool
    {
        return $this === $request;
    }


    public function cacheKey(): string
    {
        return sprintf(
            '%s-%d-%s-%d',
            $this->orientation(),
            $this->perPage(),
            $this->slugWords(),
            $this->page()
        );
    }


    private function __construct()
    {
        $this->slugify = new Slugify();
    }
}
