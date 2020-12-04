<?php

declare(strict_types=1);

namespace ImgFinder\Translate;

use ImgFinder\Cache\CacheTranslate;
use ImgFinder\RequestInterface;
use Psr\Cache\CacheItemPoolInterface;
use ReflectionClass;

class TranslatorService
{
    /** @var TranslateInterface[] */
    private $translators = [];


    /**
     * @param iterable                    $translators
     * @param CacheItemPoolInterface|null $cache
     * @throws
     * @return static
     */
    public static function init(iterable $translators, ?CacheItemPoolInterface $cache): self
    {
        $instance = new static();

        foreach ($translators as $class => $item) {
            $reflection = new ReflectionClass($class);
            $obj        = $reflection->newInstanceArgs($item['params']);

            $instance->translators[] = self::applyCache($item, $cache)
                ? new CacheTranslate($cache, $obj)
                : $obj;
        }

        return $instance;
    }


    /**
     * @param $item
     * @param CacheItemPoolInterface|null $cache
     * @return bool
     */
    public static function applyCache($item, ?CacheItemPoolInterface $cache): bool
    {
        if (empty($cache)) {
            return false;
        }

        if (!empty($item['no_cache'])) {
            return false;
        }
        
        return true;
    }


    public function translate(RequestInterface $request): RequestInterface
    {
        foreach ($this->translators as $translator) {
            $newRequest = $translator->findWord($request);
            if (!$newRequest->isEqual($request)) {
                return $newRequest;
            }
        }

        return $request;
    }


    private function __construct()
    {
    }
}
