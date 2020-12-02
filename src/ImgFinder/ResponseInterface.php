<?php

declare(strict_types=1);

namespace ImgFinder;

interface ResponseInterface
{
    public function merge(self $response): self;

    /**
     * @return iterable|array
     */
    public function toArray(): iterable;
}
