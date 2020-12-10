<?php

namespace Tests\Translator;

use ImgFinder\RequestInterface;
use ImgFinder\Translator\TranslatorInterface;

class SpyTranslator implements TranslatorInterface
{
    const NAME = 'spy-translator';


    public function __construct(string $apikey)
    {
    }


    public function getName(): string
    {
        return self::NAME;
    }


    public function findWord(RequestInterface $request): RequestInterface
    {
        return $request;
    }
}