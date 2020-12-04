<?php

declare(strict_types=1);

namespace ImgFinder\Translate;

use ImgFinder\Cache\CacheTranslate;
use ImgFinder\Cache\TraitServiceApplyCache;
use ImgFinder\RequestInterface;
use Psr\Cache\CacheItemPoolInterface;
use ReflectionClass;

class TranslatorService
{
    /** @var TranslateInterface[] */
    private $translators = [];

    use TraitServiceApplyCache;


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
            $translate  = $reflection->newInstanceArgs($item['params']);

            $instance->translators[] = self::applyCache($item, $cache)
                ? new CacheTranslate($cache, $translate)
                : $translate;
        }

        return $instance;
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
