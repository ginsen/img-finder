<?php

declare(strict_types=1);

namespace ImgFinder\Lib;

use ImgFinder\RequestInterface;

interface DictionaryInterface
{
    public function findWord(RequestInterface $request): RequestInterface;

    public function isEnabled(): bool;
}


//class Dictionary implements DictionaryInterface
//{
//    /** @var iterable|array */
//    protected $dictionary;
//
//    public function __construct(bool $enable, string $source)
//    {
//        $this->dictionary = parserFile($source);
//    }
//
//
//    public function findWord(RequestInterface $request): RequestInterface
//    {
//        $arr   = [];
//        $words = $request->getWords();
//
//        if (!array_key_exists($words, $arr)) {
//            return $request;
//        }
//
//        return $request->setWords($arr[$words]);
//    }
//
//    public function is
//}
