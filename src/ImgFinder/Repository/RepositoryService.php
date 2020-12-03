<?php

declare(strict_types=1);

namespace ImgFinder\Repository;

use ImgFinder\Config;
use ImgFinder\RequestInterface;
use ImgFinder\Response;
use ImgFinder\ResponseInterface;
use ReflectionClass;

class RepositoryService
{
    /** @var ImgRepositoryInterface[] */
    private $repositories;


    /**
     * RepositoryService constructor.
     * @param Config $config
     * @throws
     */
    public function __construct(Config $config)
    {
        foreach ($config->getRepositories() as $repo) {
            $reflection           = new ReflectionClass($repo['class']);
            $this->repositories[] = $reflection->newInstanceArgs($repo['params']);
        }
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
}
