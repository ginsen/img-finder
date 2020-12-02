<?php

declare(strict_types=1);

namespace ImgFinder\Lib;

use ImgFinder\RequestInterface;
use ImgFinder\ResponseInterface;

interface ImgRepositoryInterface
{
    public function findImages(RequestInterface $request): ResponseInterface;
}
