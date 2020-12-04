<?php

declare(strict_types=1);

namespace ImgFinder\Translate;

use ImgFinder\RequestInterface;

interface TranslateInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param RequestInterface $request
     * @return RequestInterface
     * @throws
     */
    public function findWord(RequestInterface $request): RequestInterface;
}
