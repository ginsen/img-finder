<?php

declare(strict_types=1);

namespace ImgFinder\Translate;

use ImgFinder\RequestInterface;

interface TranslateInterface
{
    public function findWord(RequestInterface $request): RequestInterface;
}
