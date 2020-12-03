<?php

declare(strict_types=1);

namespace ImgFinder;

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


    public static function fromParams(
        string $words,
        int $page = 1,
        int $perPage = 15,
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
        return self::fromParams(
            $words,
            $this->getPage(),
            $this->getPerPage(),
            $this->getOrientation()
        );
    }


    public function setPage(int $page): RequestInterface
    {
        return self::fromParams(
            $this->getWords(),
            $page,
            $this->getPerPage(),
            $this->getOrientation()
        );
    }


    public function setPerPage(int $perPage): RequestInterface
    {
        return self::fromParams(
            $this->getWords(),
            $this->getPage(),
            $perPage,
            $this->getOrientation()
        );
    }

    public function setOrientation(string $orientation): RequestInterface
    {
        return self::fromParams(
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

    public function getQueryStr(): string
    {
        return urldecode($this->getWords());
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


    private function __construct()
    {
    }
}
