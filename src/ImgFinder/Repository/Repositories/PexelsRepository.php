<?php

namespace ImgFinder\Repository\Repositories;

use ImgFinder\Repository\ImgRepositoryInterface;
use ImgFinder\RequestInterface;
use ImgFinder\Response;
use ImgFinder\ResponseInterface;

class PexelsRepository implements ImgRepositoryInterface
{
    /** @var string */
    private $authorization;


    public function __construct(string $authorization)
    {
        $this->authorization = $authorization;
    }


    public function findImages(RequestInterface $request): ResponseInterface
    {
        // TODO: Implement findImages() method.

        return Response::fromUrls([
            'https://images.pexels.com/photos/3573351/pexels-photo-3573351.png'
        ]);
    }
}
