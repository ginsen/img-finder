<?php

declare(strict_types=1);

namespace ImgFinder\Service;

use ImgFinder\Cache\CacheImgRepository;
use ImgFinder\Repository\ImgRepositoryInterface;
use ImgFinder\RequestInterface;
use ImgFinder\Response;
use ImgFinder\ResponseInterface;
use Psr\Cache\CacheItemPoolInterface;

class RepositoryService extends AbstractService
{
    /** @var ImgRepositoryInterface[] */
    private $repositories;


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
            $imgRepo = self::makeInstance($class, $item['params']);

            $instance->repositories[] = self::hasCache($item, $cache)
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
