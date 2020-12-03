<?php

declare(strict_types=1);

namespace ImgFinder\Translate\Translators;

use ImgFinder\Request;
use ImgFinder\RequestInterface;
use ImgFinder\Translate\TranslateInterface;

class GoogleTranslate implements TranslateInterface
{
    public function __construct(string $credentials, string $from, string $to)
    {
    }


    /**
     * {@inheritdoc}
     */
    public function findWord(RequestInterface $request): RequestInterface
    {
        // TODO: Implement findWord() method.

        //return Request::fromParams('some test');

        return $request;
    }
}
