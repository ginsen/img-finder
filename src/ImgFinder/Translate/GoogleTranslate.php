<?php

declare(strict_types=1);

namespace ImgFinder\Translate;

use ImgFinder\Request;
use ImgFinder\RequestInterface;

class GoogleTranslate implements TranslateInterface
{
    public function __construct(string $credentials, string $from, string $to)
    {
    }


    /**
     * {@inheritDoc}
     */
    public function findWord(RequestInterface $request): RequestInterface
    {
        // TODO: Implement findWord() method.

        return Request::fromParams('some test');
    }
}
