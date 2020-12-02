<?php

declare(strict_types=1);

namespace ImgFinder\Lib;

use ImgFinder\RequestInterface;

interface GoogleTranslateInterface
{
    public function findWord(RequestInterface $request): RequestInterface;

    public function isEnabled(): bool;
}
