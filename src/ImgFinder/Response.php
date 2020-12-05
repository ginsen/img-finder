<?php

declare(strict_types=1);

namespace ImgFinder;

class Response implements ResponseInterface
{
    /** @var iterable|array */
    private $urls;


    public static function fromUrls(iterable $urls): self
    {
        $instance       = new static();
        $instance->urls = $urls;

        return $instance;
    }


    public function merge(ResponseInterface $response): ResponseInterface
    {
        $urls = $this->toArray();
        array_push($urls, ...$response->toArray());

        return self::fromUrls($urls);
    }


    public function toArray(): array
    {
        return $this->urls;
    }


    public function isEmpty(): bool
    {
        return empty($this->urls);
    }


    private function __construct()
    {
    }
}
