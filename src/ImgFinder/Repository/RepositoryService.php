<?php

declare(strict_types=1);

namespace ImgFinder\Repository;

use ImgFinder\Cache\CacheImgRepository;
use ImgFinder\Cache\TraitServiceApplyCache;
use ImgFinder\RequestInterface;
use ImgFinder\Response;
use ImgFinder\ResponseInterface;
use Psr\Cache\CacheItemPoolInterface;
use ReflectionClass;

class RepositoryService
{
    /** @var ImgRepositoryInterface[] */
    private $repositories;

    use TraitServiceApplyCache;


    /**
     * @param iterable $repositories
     * @param CacheItemPoolInterface|null $cache
     * @throws
     * @return static
     */
    public static function init(iterable $repositories, ?CacheItemPoolInterface $cache): self
    {
        $instance = new static();

        foreach ($repositories as $class => $item) {
            $reflection = new ReflectionClass($class);
            $imgRepo    = $reflection->newInstanceArgs($item['params']);

            $instance->repositories[] = self::applyCache($item, $cache)
                ? new CacheImgRepository($cache, $imgRepo)
                : $imgRepo;
        }

        return $instance;
    }


    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function findImages(RequestInterface $request): ResponseInterface
    {
        $response = Response::fromUrls([]);

        foreach ($this->repositories as $imgRepo) {
            $newResp  = $imgRepo->findImages($request);
            $response = $response->merge($newResp);
        }

        return $response;
    }


    private function __construct()
    {
    }
}
