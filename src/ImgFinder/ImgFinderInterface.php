<?php

declare(strict_types=1);

namespace ImgFinder;

interface ImgFinderInterface
{
    public function search(RequestInterface $request): ResponseInterface;
}
