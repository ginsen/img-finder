<?php

namespace ImgFinder\Repository;

use Exception;
use ImgFinder\Payload;
use ImgFinder\RequestInterface;
use ImgFinder\Response;
use ImgFinder\ResponseInterface;
use Nyholm\Psr7\Stream;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\HttpClient\Psr18Client;

class FarmapolisProductVideoRepository extends AbstractFarmapolisRepository
{
    protected const NAME = 'farmapolis-product-video';


    protected function createBody(RequestInterface $request): StreamInterface
    {
        //todo: Required true query
        return Stream::create();
    }


    protected function createResponse(iterable $data, RequestInterface $request): ResponseInterface
    {
        // todo refactor by response
        return Response::fromUrls([]);
    }
}
