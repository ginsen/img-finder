<?php

declare(strict_types=1);

namespace ImgFinder\Repository\Repositories;

use Exception;
use GuzzleHttp\Client;
use ImgFinder\Repository\ImgRepositoryInterface;
use ImgFinder\RequestInterface;
use ImgFinder\Response;
use ImgFinder\ResponseInterface;

class PexelsRepository implements ImgRepositoryInterface
{
    /** @var string */
    private $authorization;

    /** @var Client */
    private $httpClient;


    public function __construct(string $authorization)
    {
        $this->authorization = $authorization;
        $this->httpClient    = new Client();
    }


    public function findImages(RequestInterface $request): ResponseInterface
    {
        try {
            $url  = $this->makeUrl($request);
            $data = $this->doHttpRequest($url);

            return $this->createResponse($data, $request->getOrientation());
        } catch (Exception $exception) {
            return Response::fromUrls([]);
        }
    }


    /**
     * @param RequestInterface $request
     * @return string
     */
    public function makeUrl(RequestInterface $request): string
    {
        return sprintf(
            'https://api.pexels.com/v1/search?query=%s&page=%d&per_page=%d&orientation=%s',
            $request->getQueryStr(),
            $request->getPage(),
            $request->getPerPage(),
            $request->getOrientation()
        );
    }


    /**
     * @param string $url
     * @return iterable
     */
    public function doHttpRequest(string $url): iterable
    {
        try {
            $res = $this->httpClient->get($url, [
                'headers' => [
                    'Authorization' => $this->authorization,
                ],
            ]);

            $json = (string) $res->getBody();

            return \GuzzleHttp\json_decode($json, true);
        } catch (Exception $exception) {
            return [];
        }
    }


    private function createResponse(iterable $data, string $orientation): ResponseInterface
    {
        $urls = [];

        foreach ($data['photos'] as $photo) {
            $urls[] = $photo['src'][$orientation];
        }

        return Response::fromUrls($urls);
    }
}
