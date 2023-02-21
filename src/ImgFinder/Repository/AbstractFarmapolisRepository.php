<?php

namespace ImgFinder\Repository;

use Exception;
use ImgFinder\RequestInterface;
use ImgFinder\ResponseInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\HttpClient\Psr18Client;

abstract class AbstractFarmapolisRepository implements ImgRepositoryInterface
{
    private const PUBLIC_DOMAIN = 'https://farmapolis.imgix.net/';

    private ClientInterface $httpClient;


    public function __construct(
        private string $authorization,
        private string $domain
    ) {
        $this->httpClient = new Psr18Client();
    }


    abstract protected function createBody(RequestInterface $request): StreamInterface;

    abstract protected function createResponse(iterable $data, RequestInterface $request): ResponseInterface;


    public function name(): string
    {
        return static::NAME;
    }

    
    public function findImages(RequestInterface $request): ResponseInterface
    {
        $url  = sprintf('%s/graphql', $this->domain);
        $data = $this->doHttpRequest($url, $request);

        return $this->createResponse($data, $request);
    }


    /**
     * @throws
     */
    protected function doHttpRequest(string $url, RequestInterface $finderRequest): iterable
    {
        try {
            $httpRequest = $this->httpClient->createRequest('POST', $url);
            $httpRequest = $httpRequest->withHeader('Authorization', 'Bearer ' . $this->authorization);
            $httpRequest = $httpRequest->withHeader('Content-Type', 'application/json');
            $httpRequest = $httpRequest->withBody(
                $this->createBody($finderRequest)
            );

            $response = $this->httpClient->sendRequest($httpRequest);
            $body     = $response->getBody()->getContents();

            return (array) json_decode($body, true);
        } catch (Exception) {
            return [];
        }
    }


    protected function makePublicUrl($media, int $width): string
    {
        return self::PUBLIC_DOMAIN . $media .'?w='. $width .'&auto=compress&fm=webp';
    }
}