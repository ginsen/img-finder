<?php

declare(strict_types=1);

namespace ImgFinder\Repository;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use ImgFinder\RequestInterface;
use ImgFinder\Response;
use ImgFinder\ResponseInterface;

class UnsplashRepository implements ImgRepositoryInterface
{
    const NAME    = 'unsplash';
    const PHOTOS  = 'urls';
    const RESULTS = 'results';
    const RAW     = 'raw';


    /** @var string */
    private $authorization;

    /** @var ClientInterface */
    private $httpClient;


    /**
     * @param string authorization
     */
    public function __construct(string $authorization)
    {
        $this->authorization = $authorization;
        $this->httpClient    = new Client();
    }


    public function name(): string
    {
        return self::NAME;
    }


    public function findImages(RequestInterface $request): ResponseInterface
    {
        $url  = $this->makeUrl($request);
        $data = $this->doHttpRequest($url);

        return $this->createResponse($data);
    }


    /**
     * @param RequestInterface $request
     * @return string
     */
    private function makeUrl(RequestInterface $request): string
    {
        return sprintf(
            'https://api.unsplash.com/search/photos?client_id=%s&query=%s&page=%s&per_page=%s&orientation=%s',
            $this->authorization,
            $request->urlWords(),
            $request->page(),
            $request->perPage(),
            $request->orientation()
        );
    }


    /**
     * @param string $url
     * @return iterable|array
     */
    private function doHttpRequest(string $url): iterable
    {
        try {
            $res  = $this->httpClient->get($url);
            $json = (string) $res->getBody();

            return (array) \GuzzleHttp\json_decode($json, true);
        } catch (Exception $exception) {
            return [];
        }
    }


    /**
     * @param iterable $data
     * @return ResponseInterface
     */
    private function createResponse(iterable $data): ResponseInterface
    {
        if (empty($data)) {
            return Response::fromUrls([]);
        }

        $urls = [];

        foreach ($data[self::RESULTS] as $photo) {
            $urls[] = $photo[self::PHOTOS][self::RAW];
        }

        return Response::fromUrls($urls);
    }
}
