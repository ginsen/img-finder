<?php

declare(strict_types=1);

namespace ImgFinder\Translate;

use ImgFinder\Config;
use ImgFinder\Exception\DictionaryException;
use ImgFinder\RequestInterface;

class Dictionary implements TranslateInterface
{
    /** @var string */
    private $dictionary;


    public function __construct(Config $config)
    {
        if (!$this->dictionary = $config->getDictionaryFilename()) {
            throw new DictionaryException('dictionary file not found');
        }
    }


    public function findWord(RequestInterface $request): RequestInterface
    {
        // TODO: Implement findWord() method.
    }
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
//}
