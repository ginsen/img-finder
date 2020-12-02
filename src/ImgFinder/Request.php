<?php

namespace ImgFinder;

class Request implements RequestInterface
{
    /** @var string */
    private $words;

    /** @var int */
    private $page;

    /** @var int */
    private $perPage;

    public static function fromParams(string $words, int $page = 1, int $perPage = 15): RequestInterface
    {
        $instance = new static();

        $instance->words   = $words;
        $instance->page    = $page;
        $instance->perPage = $perPage;

        return $instance;
    }


    public function setWords(string $words): RequestInterface
    {
        return self::fromParams($words, $this->getPage(), $this->getPerPage());
    }


    public function setPage(int $page): RequestInterface
    {
        return self::fromParams($this->getWords(), $page, $this->getPerPage());
    }


    public function setPerPage(int $perPage): RequestInterface
    {
        return self::fromParams($this->getWords(), $this->getPage(), $perPage);
    }


    public function getWords(): string
    {
        return $this->words;
    }


    public function getPage(): int
    {
        return $this->page;
    }


    public function getPerPage(): int
    {
        return $this->perPage;
    }


    private function __construct()
    {
    }
}