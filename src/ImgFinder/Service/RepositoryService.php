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
            $params  = !empty($item['params']) ? $item['params'] : [];
            $imgRepo = self::makeInstance($class, $params);
            $imgRepo = self::hasCache($item, $cache) ? new CacheImgRepository($cache, $imgRepo) : $imgRepo;

            $instance->repositories[$imgRepo->name()] = $imgRepo;
        }

        return $instance;
    }


    public function names(): iterable
    {
        return array_keys($this->repositories);
    }


    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function findImages(RequestInterface $request): ResponseInterface
    {
        if ($request->hasRepository()) {
            return $this->findInOneRepository($request);
        }

        return $this->findInAllRepositories($request);
    }


    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    protected function findInOneRepository(RequestInterface $request): ResponseInterface
    {
        $imgRepo = $this->repositories[$request->repository()];

        return $imgRepo->findImages($request);
    }


    /**
     * @param RequestInterface $request
     * @return Response|ResponseInterface
     */
    protected function findInAllRepositories(RequestInterface $request)
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
