<?php

namespace ImgFinder\Cache;

use Psr\Cache\CacheItemPoolInterface;

trait TraitServiceApplyCache
{
    /**
     * @param iterable                    $item
     * @param CacheItemPoolInterface|null $cache
     * @return bool
     */
    public static function applyCache(iterable $item, ?CacheItemPoolInterface $cache): bool
    {
        if (empty($cache)) {
            return false;
        }

        if (!empty($item['no_cache'])) {
            return false;
        }

        return true;
    }
}