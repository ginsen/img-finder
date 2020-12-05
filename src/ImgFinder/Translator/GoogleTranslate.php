<?php

declare(strict_types=1);

namespace ImgFinder\Translator;

use ImgFinder\RequestInterface;

class GoogleTranslate implements TranslatorInterface
{
    const NAME = 'google-translate';


    public function __construct(string $credentials, string $from, string $to)
    {
    }


    public function getName(): string
    {
        return self::NAME;
    }


    public function findWord(RequestInterface $request): RequestInterface
    {
        // TODO: Implement findWord() method.

        //return Request::fromParams('some test');

        return $request;
    }
}
