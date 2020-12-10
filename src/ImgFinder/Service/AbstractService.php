<?php

declare(strict_types=1);

namespace ImgFinder\Service;

use ImgFinder\Repository\ImgRepositoryInterface;
use ImgFinder\Translator\TranslatorInterface;
use Psr\Cache\CacheItemPoolInterface;
use ReflectionClass;

abstract class AbstractService
{
    /**
     * @param string   $class
     * @param iterable $params
     * @throws
     * @return ImgRepositoryInterface|TranslatorInterface
     */
    public static function makeInstance(string $class, iterable $params = []): object
    {
        $reflection = new ReflectionClass($class);

        if (empty($params)) {
            return $reflection->newInstance();
        }

        return $reflection->newInstanceArgs($params);
    }


    /**
     * @param iterable|null               $item
     * @param CacheItemPoolInterface|null $cache
     * @return bool
     */
    public static function hasCache(?iterable $item, ?CacheItemPoolInterface $cache): bool
    {
        if (empty($cache)) {
            return false;
        }

        if (!empty($item) && !empty($item['no_cache'])) {
            return false;
        }

        return true;
    }
}
