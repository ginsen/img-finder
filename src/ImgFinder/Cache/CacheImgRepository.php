<?php

declare(strict_types=1);

namespace ImgFinder\Cache;

use DateInterval;
use ImgFinder\Repository\ImgRepositoryInterface;
use ImgFinder\RequestInterface;
use ImgFinder\ResponseInterface;
use Psr\Cache\CacheItemPoolInterface;

class CacheImgRepository extends AbstractCache implements ImgRepositoryInterface
{
    /** @var ImgRepositoryInterface */
    private $imgRepo;

    /** @var CacheItemPoolInterface */
    private $cache;


    public function __construct(CacheItemPoolInterface $cache, ImgRepositoryInterface $imgRepo)
    {
        $this->cache   = $cache;
        $this->imgRepo = $imgRepo;
    }


    public function name(): string
    {
        return $this->imgRepo->name();
    }


    /**
     * @param RequestInterface $request
     * @throws
     * @return ResponseInterface
     */
    public function findImages(RequestInterface $request): ResponseInterface
    {
        $key  = $this->getCacheKey($request);
        $item = $this->cache->getItem($key);

        if ($item->isHit()) {
            return unserialize($item->get());
        }

        $response = $this->imgRepo->findImages($request);

        if ($response->isEmpty()) {
            return $response;
        }

        $item->set(serialize($response));
        $item->expiresAfter(new DateInterval(self::ONE_DAY));
        $this->cache->save($item);

        return $response;
    }
}
